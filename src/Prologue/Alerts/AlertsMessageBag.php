<?php namespace Prologue\Alerts;

use Illuminate\Session\Store;
use Illuminate\Config\Repository;
use Illuminate\Support\MessageBag;

class AlertsMessageBag extends MessageBag {

	/**
	 * Illuminate's Session Store.
	 *
	 * @var \Illuminate\Session\Store
	 */
	protected $session;

	/**
	 * Illuminate's Config Repository.
	 *
	 * @var \Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Initialize the AlertMessageBag class.
	 *
	 * @param  \Illuminate\Session\Store  $session
	 * @param  array  $messages
	 * @return void
	 */
	public function __construct(Store $session, Repository $config, array $messages = array())
	{
		$this->config = $config;
		$this->session = $session;

		// If there are already messages stored in the current
		// session, merge them with the provided messages.
		if ($session->has($this->getSessionKey()))
		{
			$messages = array_merge_recursive(
				$session->get($this->getSessionKey()),
				$messages
			);
		}

		parent::__construct($messages);

		if ($this->shouldAutoFlash())
		{
			$this->flash();
		}
	}

	/**
	 * Add a message to the bag.
	 *
	 * @param  string  $key
	 * @param  string  $message
	 * @return \Prologue\Alerts\AlertsMessageBag
	 */
	public function add($key, $message)
	{
		parent::add($key, $message);

		// Check if the messages need to be flashed 
		// to the session automatically.
		$this->autoFlash();

		return $this;
	}

	/**
	 * Merge a new array of messages into the bag.
	 *
	 * @param  array  $messages
	 * @return \Prologue\Alerts\AlertsMessageBag
	 */
	public function merge(array $messages)
	{
		parent::merge($messages);

		// Check if the messages need to be flashed 
		// to the session automatically.
		$this->autoFlash();

		return $this;
	}

	/**
	 * Store the messages in the current session.
	 *
	 * @return \Prologue\Alert\AlertMessageBag
	 */
	public function flash()
	{
		$this->session->flash($this->getSessionKey(), $this->messages);

		return $this;
	}

	/**
	 * If set to true, automatically flash messages to the session.
	 *
	 * @return void
	 */
	protected function autoFlash()
	{
		if ($this->shouldAutoFlash())
		{
			$this->flash();
		}
	}

	/**
	 * Determines if set messages should be auto flashed.
	 *
	 * @return bool
	 */
	protected function shouldAutoFlash()
	{
		return $this->config->get('alerts::auto_flash') ? true : false;
	}

	/**
	 * Returns the alert levels from the config.
	 *
	 * @return array
	 */
	protected function getLevels()
	{
		return $this->config->get('alerts::levels');
	}

	/**
	 * Returns the session key from the config.
	 *
	 * @return string
	 */
	protected function getSessionKey()
	{
		return $this->config->get('alerts::session_key');
	}

	/**
	 * Returns the Illuminate Session Store.
	 *
	 * @return \Illuminate\Session\Store
	 */
	public function getSession()
	{
		return $this->session;
	}

	/**
	 * Returns the Illuminate Config Repository.
	 *
	 * @return \Illuminate\Config\Repository
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * Dynamically handle alert additions.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 * @throws BadMethodCallException
	 */
	public function __call($method, $parameters)
	{
		// Check if the method is in the allowed alert levels array.
		if (in_array($method, $this->getLevels()))
		{
			return $this->add($method, $parameters[0]);
		}

		throw new \BadMethodCallException("Method [$method] does not exist.");
	}

}