<?php

namespace Classes\Example2\FileExtensions;

use Classes\Example2\OrderData;
use Interfaces\Example2\FileProcessor;

class TXT implements FileProcessor
{

    public function readFile()
    {
        // Work with txt file (read)
    }

    public function writeToFile(OrderData $data)
    {
        // Work with txt file (write)
    }
}