<?php
namespace chilimatic\lib\Log;

use chilimatic\lib\Log\Exception\LogException;

/**
 * Class Generic
 * @package chilimatic\lib\Log
 */
class Generic implements ILog
{


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
     * loglevel which messages are going to be logged
     *
     * @var int
     */
    private $logLevel = 0;


    /**
     * constructor
     *
     * @param $fileName string
     * @param $logPath  string
     *
     * @throws LogException
     */
    public function __construct($fileName, $logPath)
    {
        if (empty($fileName)) {
            throw new LogException("No filename given for logging!");
        }

        $this->fileName = $fileName;

        $this->logPath = (string) $logPath;

        if (strpos($this->fileName, '.log') === false) {
            $this->fileName .= (string)'_' . (string)date(self::LOG_DATE_FILE) . '.log';
        }
    }


    /**
     * @param string $msg
     * @param int $logLevel
     * @return bool
     * @throws LogException
     */
    public function log($msg, $logLevel = 1)
    {

        // log level check
        if ($this->logLevel > (int)$logLevel) {
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

            // if it doesn't exist add next line @ the end of the msg
            if (strpos($msg, "\n") === false) {
                $msg = "[" . (string)date(self::LOG_DATE_FORMAT) . (string)"] $msg " . "\n";
            } else {
                $msg = "[" . (string)date(self::LOG_DATE_FORMAT) . (string)"] $msg";
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
}