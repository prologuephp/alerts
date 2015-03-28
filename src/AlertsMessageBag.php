<?php
namespace Prologue\Alerts;

use BadMethodCallException;
use Illuminate\Session\Store;
use Prologue\Support\MessageBag;
use Illuminate\Config\Repository;

class AlertsMessageBag extends MessageBag
{
    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @param \Illuminate\Session\Store $session
     * @param \Illuminate\Config\Repository $config
     * @param array $messages
     * @return \Prologue\Alerts\AlertsMessageBag
     */
    public function __construct(Store $session, Repository $config, array $messages = [])
    {
        $this->config = $config;
        $this->session = $session;

        // If there are already messages stored in the current
        // session, merge them with the provided messages.
        if ($session->has($this->getSessionKey())) {
            $messages = array_merge_recursive(
                $session->get($this->getSessionKey()),
                $messages
            );
        }

        parent::__construct($messages);
    }

    /**
     * Store the messages in the current session.
     *
     * @return \Prologue\Alerts\AlertsMessageBag
     */
    public function flash()
    {
        $this->session->flash($this->getSessionKey(), $this->messages);

        return $this;
    }

    /**
     * Returns the alert levels from the config.
     *
     * @return array
     */
    public function getLevels()
    {
        return (array) $this->config->get('alerts::levels');
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
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        // Check if the method is in the allowed alert levels array.
        if (in_array($method, $this->getLevels())) {
            // Array of alerts.
            if (is_array($parameters[0])) {
                foreach ($parameters[0] as $parameter) {
                    $this->add($method, $parameter);
                }

                return $this;
            }

            // Single alert.
            return $this->add($method, $parameters[0]);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
