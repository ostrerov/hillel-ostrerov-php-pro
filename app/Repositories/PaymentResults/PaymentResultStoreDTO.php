<?php

namespace App\Repositories\PaymentResults;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;

class PaymentResultStoreDTO
{
    protected PaymentSystem $paymentSystem;

    public function __construct(
        protected TransactionStatus $status,
        protected string $orderId,
        protected string $paymentId,
        protected int $userId,
        protected string $amount,
        protected Currency $currency
    ) {
    }

    /**
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getAmount(): string
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
     * @return PaymentSystem
     */
    public function getPaymentSystem(): PaymentSystem
    {
        return $this->paymentSystem;
    }

    /**
     * @param PaymentSystem $paymentSystem
     */
    public function setPaymentSystem(PaymentSystem $paymentSystem): void
    {
        $this->paymentSystem = $paymentSystem;
    }
}
