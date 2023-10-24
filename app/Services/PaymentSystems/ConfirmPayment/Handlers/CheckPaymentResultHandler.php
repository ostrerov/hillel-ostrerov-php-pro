<?php

namespace App\Services\PaymentSystems\ConfirmPayment\Handlers;

use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentInterface;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Ostrerov\Pakage\Enums\Status;
use Ostrerov\Pakage\PaymentSystems\PaymentSystemFactory;
use Throwable;

class CheckPaymentResultHandler implements ConfirmPaymentInterface
{
    public function __construct(
        protected PaymentSystemFactory $paymentSystemFactory,
    ) {
    }

    /**
     * @throws BindingResolutionException|Throwable
     */
    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $paymentService = $this->paymentSystemFactory->getInstance(
            $confirmPaymentDTO->getPaymentSystem(),
            config('paymentSystems')
        );

        $paymentInfo = $paymentService->getPaymentInfo($confirmPaymentDTO->getPaymentId());

        $confirmPaymentDTO->setPaymentSuccess(
            $paymentInfo->getStatus() === Status::SUCCESS
        );
        $confirmPaymentDTO->setPaymentInfo($paymentInfo);

        return $next($confirmPaymentDTO);
    }
}
