<?php
namespace chilimatic\lib\Log\Client;

/**
 * Class ToFile
 * @package chilimatic\lib\Log\Client
 */
class ToFile extends AbstractClient
{
    /**
     * @var string
     */
    private $targetFile;


    /**
     * @path
     */
    public function send()
    {
        $format = $this->getFormat();

        $msgString = '';
        if ($format) {
            foreach ($this->logMessages as $message) {
                $msgString .= $format->format($message);
            }
        } else {
            foreach ($this->logMessages as $message) {
                $msgString .= implode(' ', $message);
            }
        }

        if (!$this->targetFile) {
            error_log($msgString);
        } else {
            file_put_contents($this->targetFile, $msgString, FILE_APPEND);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getTargetFile()
    {
        return $this->targetFile;
    }

    /**
     * @param string $targetFile
     *
     * @return $this
     */
    public function setTargetFile($targetFile)
    {
        $this->targetFile = $targetFile;

        return $this;
    }
}