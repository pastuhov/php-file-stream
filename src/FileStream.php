<?php
namespace pastuhov\FileStream;

class FileStream extends BaseFileStream
{
    /**
     * File header.
     *
     * Any file will be started from that string.
     *
     * @var string
     */
    protected $header;

    /**
     * File footer.
     *
     * Any file will be ended at that string.
     *
     * @var string
     */
    protected $footer;

    /**
     * Max possible writes to one file.
     * @var int
     */
    protected $maxCount;

    /**
     * File name count placeholder.
     * @var string
     */
    protected $countPlaceHolder = '{count}';

    /**
     * Current writes count.
     * @var int
     */
    protected $currentCount = 0;

    /**
     * Current files count.
     * @var int
     */
    protected $currentFileCount = 0;

    /**
     * List of Files
     * @var array
     */
    protected $files = [];

    /**
     * @inheritdoc
     * @param string|null $header File header
     * @param string|null $footer File footer
     * @param int|bool|false $maxCount Max possible writes to one file
     * @throws \Exception
     */
    public function __construct($fileName, $header = null, $footer = null, $maxCount = false)
    {
        parent::__construct($fileName);

        $this->header = $header;
        $this->footer = $footer;
        $this->maxCount = $maxCount;

        if ($this->maxCount !== false && strpos($this->fileName, $this->countPlaceHolder) === false) {
            throw new \Exception('File name ' . $this->countPlaceHolder . ' placeholder is needed');
        }
    }

    /**
     * Adds the given Filename to the internal Array
     * @param $filename
     */
    public function addFile($filename)
    {
        $this->files[] = $filename;
    }

    /**
     * Returns the List of written Files
     * @return array
     */
    public function getFileList()
    {
        return $this->files;
    }

    /**
     * @inheritdoc
     */
    protected function openHandle()
    {
        parent::openHandle();
        $this->addFile($this->getFileName());
        if ($this->header !== null) {
            $this->write($this->header, false);
        }
    }

    /**
     * @inheritdoc
     * @param bool $count
     * @throws \Exception
     */
    public function write($string, $count = true)
    {
        parent::write($string);

        if ($count) {
            $this->currentCount++;
            if ($this->currentCount === $this->maxCount) {
                $this->closeHandle();
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function closeHandle()
    {
        if ($this->footer !== null) {
            $this->write($this->footer, false);
        }

        parent::closeHandle();

        $this->currentFileCount++;
        $this->currentCount = 0;
    }

    /**
     * Base file name with replaced count placeholder.
     * @return string Base file name with replaced placeholder
     */
    protected function getFileName()
    {
        $fileName = parent::getFileName();

        if ($this->maxCount !== false) {
            $fileName = strtr($fileName, [$this->countPlaceHolder => $this->currentFileCount]);
        }

        return $fileName;
    }
}