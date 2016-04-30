<?php
namespace chilimatic\lib\Log\Client;
use chilimatic\lib\Log\Formatter\LogFormatter;

/**
 * Interface ClientInterface
 *
 * @package chilimatic\lib\Log\Client
 */
Interface ClientInterface
{

    /**
     * ClientInterface constructor.
     * @param LogFormatter|null $format
     * @param array $options
     */
    public function __construct(LogFormatter $format = null, $options = []);

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return self
     */
    public function log($message, $data);

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return self
     */
    public function info($message, $data);

    /**
     * @param string $message
     * @param $mixed $data
     *
     * @return self
     */
    public function warn($message, $data);

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return self
     */
    public function error($message, $data);

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return self
     */
    public function trace($message, $data);

    /**
     * @return mixed
     */
    public function showError();

    /**
     * @param LogFormatter $format
     *
     * @return mixed
     */
    public function setFormat(LogFormatter $format);

    /**
     * @return LogFormatter|null
     */
    public function getFormat();

    /**
     * @return mixed
     */
    public function send();
}