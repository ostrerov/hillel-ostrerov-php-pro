<?php

namespace App\Services\PaymentSystems;

use App\Services\PaymentSystems\ConfirmPayment\PaymentInfoDTO;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;

interface PaymentSystemInterface
{
    /**
     * @param string $paymentId
     * @return PaymentInfoDTO
     */
    public function validatePayment(string $paymentId): PaymentInfoDTO;

    /**
     * @param MakePaymentDTO $makePaymentDTO
     * @return string
     */
    public function createPayment(MakePaymentDTO $makePaymentDTO): string;
}
