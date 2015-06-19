<?php
namespace pastuhov\FileStream\Test;

use pastuhov\FileStream\FileStream;
use pastuhov\FileStream\RenameCommand;

class FileStreamTest extends \PHPUnit_Framework_TestCase
{
    protected $runtimeDir;

    /**
     * Setting test up
     */
    protected function setUp()
    {
        $this->runtimeDir = __DIR__ . '/tmp';
    }

    /**
     * Simple test in one file write.
     * @throws \Exception
     */
    public function testOneHandle()
    {
        $stream = new FileStream(
            $this->runtimeDir . '/export.yml'
        );

        $stream->write('<yml_catalog date="2010-04-01 17:00">');
        $stream->write('<shop>');
        $stream->write('<name>Magazin</name>');
        $stream->write('</shop>');
        $stream->write('</yml_catalog>');

        $stream = null;

        $this->assertFileEquals(__DIR__ . '/fixtures/file.yml', $this->runtimeDir . '/' . 'export.yml');
    }

    /**
     * Test multiple file creation.
     * @throws \Exception
     */
    public function testMultipleHandles()
    {
        $stream = new FileStream(
            $this->runtimeDir . '/sitemap{count}.xml',
            '<urlset>',
            '</urlset>',
            3
        );

        $stream->addCommand(new RenameCommand($this->runtimeDir, '_renamed'));

        foreach ($urls = range(0, 7) as $url) {
            $stream->write(
                '<url><loc>https://github.com?page' . $url . '</loc></url>' . PHP_EOL
            );
        }

        $stream = null;

        $this->assertFileEquals(__DIR__ . '/fixtures/sitemap0.xml', $this->runtimeDir . '/' . 'sitemap0.xml_renamed');
        $this->assertFileEquals(__DIR__ . '/fixtures/sitemap1.xml', $this->runtimeDir . '/' . 'sitemap1.xml_renamed');
        $this->assertFileEquals(__DIR__ . '/fixtures/sitemap2.xml', $this->runtimeDir . '/' . 'sitemap2.xml_renamed');
    }

    /**
     * Test constructor placeholder validation.
     */
    public function testPlaceholderValidation()
    {
        $this->setExpectedException('Exception', 'File name {count} placeholder is needed');

        $stream = new FileStream(
            'sitemap.xml',
            $this->runtimeDir . '/runtime',
            $this->runtimeDir . '/public',
            '<urlset>',
            '</urlset>',
            3
        );
    }
}
