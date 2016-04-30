<?php
namespace chilimatic\lib\Log;

/**
 * Interface ILog
 * @package chilimatic\lib\Log
 */
Interface ILog
{
    /**
     * binary error code
     */
    const T_ERROR = 1;

    /**
     * binary warning code
     */
    const T_WARNING = 2;

    /**
     * binary info code
     */
    const T_INFO = 3;

    /**
     * Default Log format
     *
     * @var string
     */
    CONST LOG_DATE_FORMAT = 'Y-m-d H:i:s';


    /**
     * default log date filename
     *
     * @var string
     */
    CONST LOG_DATE_FILE = 'Y-m-d';


    /**
     * ILog constructor.
     * @param $fileName
     * @param $logPath
     */
    public function __construct($fileName, $logPath);


    /**
     * @param string $msg
     * @param int $logLevel
     * @return mixed
     */
    public function log($msg, $logLevel = 0);
}