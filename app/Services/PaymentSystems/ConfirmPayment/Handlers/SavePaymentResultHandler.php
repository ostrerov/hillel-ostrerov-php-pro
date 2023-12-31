<?php

namespace App\Services\PaymentSystems\ConfirmPayment\Handlers;

use App\Repositories\PaymentResults\PaymentResultRepository;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentInterface;
use Closure;

class SavePaymentResultHandler implements ConfirmPaymentInterface
{
    public function __construct(
        protected PaymentResultRepository $paymentResultRepository,
    ) {
    }

    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $this->paymentResultRepository->store($confirmPaymentDTO->getPaymentInfo());

        return $next($confirmPaymentDTO);
    }
}
