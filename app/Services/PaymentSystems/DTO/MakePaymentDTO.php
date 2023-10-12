<?php

namespace App\Services\PaymentSystems\DTO;

use App\Enums\Currency;

class MakePaymentDTO
{
    public function __construct(
        protected float $amount,
        protected Currency $currency,
        protected string $orderId,
        protected string $description = '',
    ) {
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }
}