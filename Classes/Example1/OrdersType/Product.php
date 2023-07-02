<?php

namespace Classes\Example1\OrdersType;

use Classes\Example1\OrderData;
use Classes\Example1\InvoiceProcess;
use Interfaces\Example1\Invoice;

class Product extends InvoiceProcess implements Invoice
{

    /**
     * @param  OrderData  $data
     * @return void
     */
    public function generateInvoice(OrderData $data): void
    {
        $this->type->generateType($data);
    }
}