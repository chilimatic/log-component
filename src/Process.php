<?php
namespace chilimatic\lib\Log;

/**
 * Class Process
 * @package chilimatic\lib\Log
 */
class Process extends Generic
{
    /**
     * constructor
     *
     * @param $fileName string
     * @param $logPath  string
     */
    public function __construct($fileName, $logPath)
    {
        $fileName = (string)(!empty($fileName) ? $fileName : 'process_log_' . date(self::LOG_DATE_FILE) . '.log');
        parent::__construct($fileName, $logPath);
    }
}