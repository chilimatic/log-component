<?php

namespace chilimatic\lib\Log\Client;
use chilimatic\lib\Log\Formatter\LogFormatter;

/**
 * Class AbstractClient
 * @package chilimatic\lib\Log\Client
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     * @var LogFormatter
     */
    protected $format;

    /**
     * @var \SPLQueue
     */
    protected $logMessages;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param LogFormatter $format
     */
    public function __construct(LogFormatter $format = null, $options = [])
    {
        $this->format      = $format;
        $this->logMessages = new \SplQueue();
        $this->options = $options;
    }


    abstract public function __toString();

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return $this
     */
    public function log($message, $data)
    {
        // TODO: Implement log() method.
        $this->logMessages->enqueue([
            'date'    => date('Y-m-d H:i:s'),
            'message' => $message,
            'data'    => $data
        ]);

        return $this;
    }

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return $this
     */
    public function info($message, $data)
    {
        $this->logMessages->enqueue([
            'prefix'  => 'info',
            'date'    => date('Y-m-d H:i:s'),
            'message' => $message,
            'data'    => $data
        ]);

        return $this;
    }

    /**
     * @param string $message
     * @param $mixed $data
     *
     * @return self
     */
    public function warn($message, $data)
    {
        $this->logMessages->enqueue([
            'prefix'  => 'warn',
            'date'    => date('Y-m-d H:i:s'),
            'message' => $message,
            'data'    => $data
        ]);

        return $this;
    }

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return self
     */
    public function error($message, $data)
    {
        // TODO: Implement error() method.
        $this->logMessages->enqueue([
            'prefix'  => 'error',
            'date'    => date('Y-m-d H:i:s'),
            'message' => $message,
            'data'    => $data
        ]);

        return $this;
    }

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return self
     */
    public function trace($message, $data)
    {
        // TODO: Implement trace() method.
        $this->logMessages->enqueue([
            'date'    => date('Y-m-d H:i:s'),
            'message' => $message,
            'data'    => $data
        ]);

        return $this;
    }

    /**
     * @return mixed
     */
    public function showError()
    {
        return true;
    }

    /**
     * @param LogFormatter $format
     *
     * @return mixed
     */
    public function setFormat(LogFormatter $format)
    {
        $this->format = $format;
    }

    /**
     * @return LogFormatter|null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return mixed
     */
    abstract public function send();


    public function __destruct() {
        // if the logger is destroyed we always send the errors :)
        $this->send();
    }
}