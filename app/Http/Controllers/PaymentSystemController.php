<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymentConfirmRequest;
use App\Services\OrderPaymentService;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentService;
use App\Services\Users\UserAuthService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Ostrerov\Pakage\Enums\Currency;
use Ostrerov\Pakage\Enums\PaymentSystem;
use Ostrerov\Pakage\PaymentSystems\DTO\MakePaymentDTO;
use Ostrerov\Pakage\PaymentSystems\PaymentSystemFactory;
use Throwable;

class PaymentSystemController extends Controller
{
    public function __construct(
        protected PaymentSystemFactory $paymentSystemFactory,
        protected OrderPaymentService $orderPaymentService,
        protected UserAuthService $userAuthService,
    ) {
    }

    /**
     * @throws BindingResolutionException|Throwable
     */
    public function createPayment(int $system): JsonResponse
    {
        $paymentService = $this->paymentSystemFactory->getInstance(
            PaymentSystem::from($system),
            config('paymentSystems'),
        );

        $orderId = $this->orderPaymentService->store();

        $makePaymentDTO = new MakePaymentDTO(
            20.00,
            Currency::USD,
            $orderId
        );

        $json = $paymentService->createPayment($makePaymentDTO);
        $data = json_decode($json, true);

        return response()->json([
            'order' => [
                'id'    => $data['id'],
                'sig'   => $data['sig'] ?? '',
            ],
        ]);
    }

    public function confirmPayment(
        PaymentConfirmRequest $request,
        ConfirmPaymentService $confirmPaymentService,
        int $system
    ): JsonResponse {
        $data = $request->validated();

        $confirmPaymentService->handle(
            PaymentSystem::from($system),
            $data['paymentId']
        );

        return response()->json();
    }
}
