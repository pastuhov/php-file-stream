<?php
namespace pastuhov\FileStream;

/**
 * Class BaseFileStream.
 * @package pastuhov\FileStream
 */
class BaseFileStream
{
    /**
     * Base file name.
     *
     * Example:
     * /var/www/export.yml
     * /var/www/sitemap{count}.xml
     *
     * @var string
     */
    protected $fileName;

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
     * @param string $fileName file name
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    private $_handle = false;

    /**
     * Get file handle.
     * @return bool|resource
     * @throws \Exception
     */
    public function getHandle()
    {
        if ($this->_handle === false) {
            $this->openHandle();
        }

        return $this->_handle;
    }

    /**
     * Open new file handle.
     * @throws \Exception
     */
    protected function openHandle()
    {
        $fileName = $this->getFileName();

        $this->_handle = fopen($fileName, 'w');

        if (!$this->_handle) {
            throw new \Exception('Cannot open file ' . $fileName);
        }
    }

    /**
     * Binary-safe file handle write.
     * @param string $string contents
     * @throws \Exception
     */
    public function write($string)
    {
        $fileName = $this->getFileName();
        $handle = $this->getHandle();

        if (fwrite($handle, $string) === false) {
            throw new \Exception('Cannot write to file ' . $fileName);
        }
    }

    /**
     * Close file handle.
     * @throws \Exception
     */
    protected function closeHandle()
    {
        $handle = $this->getHandle();
        fclose($handle);
        $this->_handle = false;
    }

    /**
     * Base file name with replaced count placeholder.
     * @return string Base file name with replaced placeholder
     */
    protected function getFileName()
    {
        $fileName = $this->fileName;

        return $fileName;
    }

    /**
     * Destruct.
     */
    public function __destruct()
    {
        $this->closeHandle();
    }
}
