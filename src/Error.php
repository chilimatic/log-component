<?php
namespace chilimatic\lib\Log;

use chilimatic\lib\Log\Exception\LogException;

/**
 * Class Error
 * @package chilimatic\lib\Log
 */
class Error implements ILog
{

    const XML_HEAD = '<?xml version="1.0" encoding="UTF-8" ?>';
    const ERROR_LOG_DEFAULT_PATH = './';
    const ERROR_LOG_DEFAULT_LEVEL = -1;
    const ERROR_LOG_DEFAULT_FILENAME = 'error_log_';


    /**
     * path to the logs
     *
     * @var string
     */
    protected $logPath = '';


    /**
     * name of the file
     *
     * @var string
     */
    protected $fileName = '';


    /**
     * file object
     *
     * @var object
     */
    public $file;


    /**
     * message string
     *
     * @var string
     */
    public $msg;


    /**
     * loglevel which messages are going to be logged
     *
     * @var int
     */
    private $logLevel = 0;

    /**
     * @var string
     */
    private $logType = 'xml';


    /**
     * Constructor
     *
     * @param $fileName string
     * @param $logPath  string
     */
    public function __construct($fileName = '', $logPath = '')
    {

        $this->logPath  = (string) (!empty($logPath) ? $logPath :  self::ERROR_LOG_DEFAULT_PATH);
        $this->logLevel = (string) (!empty($logPath) ? $logPath : self::ERROR_LOG_DEFAULT_LEVEL);
        $this->fileName = (string) (!empty($fileName) ? $fileName : self::ERROR_LOG_DEFAULT_FILENAME . '_' . date('Y-m-d') . '.log');

        if (strpos($this->fileName, '.log') === false && strpos($this->fileName, '.xml') === false) {
            $this->fileName .= (string)'_' . (string)date('Y-m-d') . '.log';
        }
    }


    /**
     * @param string $msg
     * @param int $logLevel
     * @return bool
     * @throws LogException
     */
    public function log($msg, $logLevel = 0)
    {
        // log level check
        if ($this->logLevel > (int) $logLevel) {
            return true;
        }

        if (!$this->file) {
            $this->file = new \SplFileObject("$this->logPath/$this->fileName");
        }


        try {
            if (!$this->file->isFile() && !$this->file->openFile('a+')) {
                // $message = null, $code = null, $previous = null
                throw new LogException((string)"file: $this->logPath/$this->fileName couldn't be created.");
            }

            switch ($this->logType) {
                case 'xml' :
                    $this->msg = '';
                    if ($this->file->read() == "") {
                        $this->msg = self::XML_HEAD . "\n";
                    }
                    $this->msg .= $msg;
                    break;
                default :
                    // if it doesn't exist add next line @ the end of the msg
                    if (strpos($msg, "\n") === false) {
                        $this->msg = "[" . (string)date(self::LOG_DATE_FORMAT) . (string)"] $msg " . "\n";
                    } else {
                        $this->msg = "[" . (string)date(self::LOG_DATE_FORMAT) . (string)"] $msg";
                    }
                    break;
            }

            if (!$this->file->fwrite($msg, strlen($msg))) {
                throw new LogException((string)"$msg was not appended to file: $this->logPath/$this->fileName.");
            }
        } catch (LogException $e) {
            error_log($e->getMessage());
            throw $e;
        }

        return true;
    }


    /**
     * (non-PHPdoc)
     *
     * @see Log::__destruct()
     */
    public function __destruct()
    {
        if (!empty($this->file)) {
            unset($this->file);
        }
    }
}