<?php

namespace Classes\Example2\FileExtensions;

use Classes\Example2\OrderData;
use Interfaces\Example2\FileProcessor;

class CSV implements FileProcessor
{

    public function readFile()
    {
        // Work with csv file (read)
    }

    public function writeToFile(OrderData $data)
    {
        // Work with csv file (write)
    }
}