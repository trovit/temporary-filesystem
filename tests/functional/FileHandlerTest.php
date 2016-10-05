<?php
namespace Trovit\TemporaryFilesystem\Tests\Functional;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use Trovit\TemporaryFilesystem\FileHandler;

class FileHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileHandler
     */
    private $sut;

    public function setUp()
    {
        vfsStream::setup('exampleDir');
        $this->sut = new FileHandler(vfsStream::url('exampleDir').'/test/');
    }

    public function testCreateTemporaryFile()
    {
        $filePath = $this->sut->createTemporaryFileFromString('code');
        $this->assertFileExists($filePath);
    }

    public function testCreateTemporaryDirectoryWhenNotFound()
    {

        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild('test'));

        $this->sut->createTemporaryFileFromString('code');

        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('test'));
    }

    public function testDeleteTemporaryFile()
    {
        $filePath = $this->sut->createTemporaryFileFromString('code');
        $this->sut->deleteTemporaryFile($filePath);
        $this->assertFileNotExists($filePath);
    }

    public function testGetFileContent()
    {
        $filePath = $this->sut->createTemporaryFileFromString('code');
        $this->assertEquals('code', file_get_contents($filePath));
    }
}

