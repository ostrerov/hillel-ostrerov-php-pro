<?php

namespace Classes\Example1\OrdersType;

use Classes\Example1\InvoiceProcess;
use Classes\Example1\OrderData;
use Interfaces\Example1\Invoice;

class Delivery extends InvoiceProcess implements Invoice
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