<?php

namespace Classes\Example1;

use Interfaces\Example1\InvoiceType;

abstract class InvoiceProcess
{
    /**
     * @param  InvoiceType  $type
     */
    public function __construct(protected InvoiceType $type)
    {
    }
}