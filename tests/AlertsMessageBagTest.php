<?php

use Mockery as m;
use Prologue\Alerts\AlertsMessageBag;

class AlertsMessageBagTest extends PHPUnit_Framework_TestCase {

	public $session;

	public $config;

	public $levels = array(
		'info',
		'warning',
		'error',
		'success',
	);

	public $sessionKey = 'alert_messages';

	public function tearDown()
	{
		m::close();
	}

	protected function mockDependencies()
	{
		$this->session = m::mock('Illuminate\Session\Store');
		$this->session->shouldReceive('has')
		              ->once()
		              ->andReturn(false);
		$this->config = m::mock('Illuminate\Config\Repository');
		$this->config->shouldReceive('get')
		             ->once()
		             ->andReturn($this->sessionKey);
	}

	protected function mockAlertsMessageBag()
	{
		$this->mockDependencies();

		return new AlertsMessageBag($this->session, $this->config);
	}

	public function testAddByLevel()
	{
		$bag = $this->mockAlertsMessageBag();

		$this->config->shouldReceive('get')
		             ->once()
		             ->andReturn($this->levels);

		$bag->error('foo');

		$messages = $bag->get('error');

		$this->assertEquals(array('foo'), $messages);
	}

	/**
	 * @expectedException BadMethodCallException
	 */
	public function testIncorrectLevel()
	{
		$bag = $this->mockAlertsMessageBag();

		$this->config->shouldReceive('get')
		             ->once()
		             ->andReturn($this->levels);

		$bag->debug('foo');
	}

	public function testFlashMessages()
	{
		$bag = $this->mockAlertsMessageBag();

		$bag->add('error', 'foo');

		$this->session->shouldReceive('flash')
		              ->once();
		$this->config->shouldReceive('get')
		             ->once()
		             ->andReturn($this->sessionKey);

		$bag->flash();

		$bagSession = $bag->getSession();

		$this->session->shouldReceive('get')
		              ->once()
		              ->andReturn(array('error' => array('foo')));

		$messages = $bagSession->get($this->sessionKey);

		$this->assertEquals(array('error' => array('foo')), $messages);
	}

	public function testAddMultipleMessagesToAlertLevel()
	{
		$bag = $this->mockAlertsMessageBag();

		$this->config->shouldReceive('get')
			->once()
			->andReturn($this->levels);

		$messages = array('foo', 'bar', 'baz');

		$bag->error($messages);

		$this->assertEquals($messages, $bag->get('error'));
	}

}