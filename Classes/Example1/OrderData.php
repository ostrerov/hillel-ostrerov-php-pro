<?php

namespace Classes\Example1;

use Interfaces\Example1\Invoice;

class OrderData
{
    /**
     * @param  string  $title
     * @param  InvoiceProcess  $type
     * @param  array  $data
     */
    public function __construct(
        protected string $title,
        protected Invoice $type,
        protected array $data
    ) {
    }

    /**
     * @return InvoiceProcess
     */
    public function getType(): Invoice
    {
        return $this->type;
    }
}