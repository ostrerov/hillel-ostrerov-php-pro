<?php

namespace Classes\Example2;

class OrderData
{
    /**
     * @param  int  $number
     * @param  array  $customer
     * @param  array  $data
     */
    public function __construct(
        protected int $number,
        protected array $customer,
        protected array $data
    ) {
    }
}