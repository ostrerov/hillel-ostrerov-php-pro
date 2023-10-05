<?php

namespace App\Services\PaymentSystems;

use App\Services\PaymentSystems\DTO\MakePaymentDTO;

interface PaymentSystemInterface
{
    /**
     * @param MakePaymentDTO $makePaymentDTO
     * @return bool
     */
    public function makePayment(MakePaymentDTO $makePaymentDTO): bool;
}
