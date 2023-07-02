<?php

namespace Classes\Example1;

use Interfaces\Example1\Invoice;

class OrderProcessor
{
    /**
     * @param  InvoiceProcess  $invoice
     */
    public function __construct(protected Invoice $invoice)
    {
    }
}