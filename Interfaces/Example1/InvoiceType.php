<?php

namespace Interfaces\Example1;

use Classes\Example1\OrderData;

interface InvoiceType
{
    public function generateType(OrderData $data);
}