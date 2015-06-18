<?php
namespace pastuhov\FileStream\Test;

use pastuhov\FileStream\FileStream;

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
            'export.yml',
            $this->runtimeDir . '/runtime',
            $this->runtimeDir . '/public'
        );

        $stream->write('<yml_catalog date="2010-04-01 17:00">');
        $stream->write('<shop>');
        $stream->write('<name>Magazin</name>');
        $stream->write('</shop>');
        $stream->write('</yml_catalog>');

        $this->assertFileExists($this->runtimeDir . '/runtime/' . 'export.yml');

        $stream = null;

        $this->assertFileNotExists($this->runtimeDir . '/runtime/' . 'export.yml');
        $this->assertFileEquals(__DIR__ . '/fixtures/file.yml', $this->runtimeDir . '/public/' . 'export.yml');
    }

    /**
     * Test multiple file creation.
     * @throws \Exception
     */
    public function testMultipleHandles()
    {
        $stream = new FileStream(
            'sitemap{count}.xml',
            $this->runtimeDir . '/runtime',
            $this->runtimeDir . '/public',
            '<urlset>',
            '</urlset>',
            3
        );

        foreach ($urls = range(0, 7) as $url) {
            $stream->write(
                '<url><loc>https://github.com?page' . $url . '</loc></url>' . PHP_EOL
            );
        }

        $stream = null;

        $this->assertFileEquals(__DIR__ . '/fixtures/sitemap0.xml', $this->runtimeDir . '/public/' . 'sitemap0.xml');
        $this->assertFileEquals(__DIR__ . '/fixtures/sitemap1.xml', $this->runtimeDir . '/public/' . 'sitemap1.xml');
        $this->assertFileEquals(__DIR__ . '/fixtures/sitemap2.xml', $this->runtimeDir . '/public/' . 'sitemap2.xml');
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
