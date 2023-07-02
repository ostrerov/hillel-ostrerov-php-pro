<?php

namespace Classes\Example1\InvoiceTypes;

use Classes\Example1\OrderData;
use Interfaces\Example1\InvoiceType;

class CSV implements InvoiceType
{

    /**
     * @param  OrderData  $data
     * @return void
     */
    public function generateType(OrderData $data): void
    {
        // Generate invoice on CSV
    }
}