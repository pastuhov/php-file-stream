<?php
namespace pastuhov\FileStream;

/**
 * Interface CommandInterface
 * @package pastuhov\FileStream
 */
interface CommandInterface
{
    public function runCommand($filename);
}