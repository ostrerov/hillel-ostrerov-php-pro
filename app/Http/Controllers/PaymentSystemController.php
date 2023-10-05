<?php

namespace App\Http\Controllers;

use App\Enums\PaymentSystem;
use App\Http\Requests\Payment\MakePaymentRequest;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class PaymentSystemController extends Controller
{
    public function __construct(
        protected PaymentSystemFactory $paymentSystemFactory
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function makePayment(MakePaymentRequest $request)
    {
        $dto = new MakePaymentDTO(...$request->validated());
        $paymentService = $this->paymentSystemFactory->getInstance(
            PaymentSystem::from((int)$request->validated('paymentSystem'))
        );

        $paymentService->makePayment($dto);
    }
}
