<?php
namespace pastuhov\FileStream;

/**
 * Rename file command
 */
class RenameCommand implements CommandInterface
{
    /**
     * @var string destination directory
     */
    protected $dstDir;

    /**
     * @var string destination file suffix
     */
    protected $suffix;

    /**
     * @param string $dstDir
     * @param string $suffix
     */
    public function __construct($dstDir, $suffix = '')
    {
        $this->dstDir = rtrim($dstDir, '/');
        $this->suffix = $suffix;
    }

    /**
     * @param string $filename
     */
    public function runCommand($filename)
    {
        rename(
            $filename,
            $this->dstDir . '/' . basename($filename) . $this->suffix
        );
    }
}
