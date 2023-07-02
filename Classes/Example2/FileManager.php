<?php

namespace Classes\Example2;

use Interfaces\Example2\FileProcessor;

class FileManager
{
    /**
     * @param  FileProcessor  $file
     * @return void
     */
    public function readFile(FileProcessor $file)
    {
        $file->readFile();
    }

    /**
     * @param  FileProcessor  $file
     * @return void
     */
    public function writeFile(FileProcessor $file)
    {
        $file->readFile();
    }
}