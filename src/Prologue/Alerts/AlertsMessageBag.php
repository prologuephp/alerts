<?php namespace Prologue\Alerts;

use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

class AlertsMessageBag extends MessageBag {

	/**
	 * Illuminate's Session Handler.
	 *
	 * @var \Illuminate\Session\Store
	 */
	protected $session;

	/**
	 * The session key which is used to store the messages.
	 *
	 * @var string
	 */
	protected $sessionKey = 'alert_messages';

	/**
	 * Initialize the AlertMessageBag class.
	 *
	 * @param  \Illuminate\Session\Store  $session
	 * @param  array  $messages
	 * @return void
	 */
	public function __construct(Store $session, array $messages = array())
	{
		$this->session = $session;

		// If there are already messages stored in the current
		// session, merge them with the provided messages.
		if ($session->has($this->sessionKey))
		{
			$messages = array_merge_recursive(
				$session->get($this->sessionKey),
				$messages
			);
		}

		parent::__construct($messages);
	}

	/**
	 * Store the messages in the current session.
	 *
	 * @return \Prologue\Alert\AlertMessageBag
	 */
	public function flash()
	{
		$this->session->flash($this->sessionKey, $this->messages);

		return $this;
	}

}