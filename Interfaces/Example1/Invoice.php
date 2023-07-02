<?php

namespace Interfaces\Example1;

use Classes\Example1\OrderData;

interface Invoice
{
    public function generateInvoice(OrderData $data): void;
}