<?php

namespace Interfaces\Example2;

use Classes\Example2\OrderData;

interface FileProcessor
{
    public function readFile();

    public function writeToFile(OrderData $data);
}