<?php
namespace chilimatic\lib\Log\Client;

/**
 * Class PrintOut
 * @package chilimatic\lib\Log\Client
 */
class PrintOut extends AbstractClient
{
    /**
     * @return string
     */
    public function send()
    {
        $msg = '';
        foreach ($this->logMessages as $message) {
            $msg .= $message['date'] . '-' . $message['message'] . '-' . print_r($message['data'], true) . "\n";
        }

        return $msg;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->send();
    }
}