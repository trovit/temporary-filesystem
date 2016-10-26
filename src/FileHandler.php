<?php
namespace Trovit\TemporaryFilesystem;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileHandler
 *
 * File utilities
 *
 * @package Kolekti\SyntacticValidationToolsBundle\Model\Utils
 */
class FileHandler
{
    /**
     * @var string $tmpDir temporary directory
     */
    private $tmpDir;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * FileHandler constructor.
     * @param string $tmpDir
     */
    public function __construct(
        $tmpDir
    ) {
        $this->filesystem = new Filesystem();
        $this->tmpDir     = $tmpDir;
    }

    /**
     * @param string $content
     * @param string $prefix
     * @param string $extension
     * @return string file path
     */
    public function createTemporaryFileFromString(
        $content,
        $prefix = 'input_',
        $extension = 'php'
    )
    {
        $this->createTemporaryDirectory();
        $filePath = $this->tmpDir . uniqid($prefix, true) . '.'. $extension;
        $this->filesystem->dumpFile($filePath, $content);
        return $filePath;
    }

    /**
     * @param string $filePath
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function deleteTemporaryFile($filePath)
    {
        $this->filesystem->remove($filePath);
    }

    /**
     * @param string $filePath
     * @return string
     */
    public function getFileContent($filePath)
    {
        return file_get_contents($filePath);
    }

    /**
     * create a temporary directory if its not already created
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    private function createTemporaryDirectory()
    {
        if (!$this->filesystem->exists($tmpDir = $this->tmpDir)) {
            $this->filesystem->mkdir($tmpDir);
        }
    }
}
