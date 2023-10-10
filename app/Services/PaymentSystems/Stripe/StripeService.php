<?php

namespace App\Services\PaymentSystems\Stripe;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use App\Services\PaymentSystems\ConfirmPayment\PayerDTO;
use App\Services\PaymentSystems\ConfirmPayment\PaymentInfoDTO;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemInterface;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService implements PaymentSystemInterface
{
    public function __construct(
        protected StripeClient $stripe
    ) {
    }

    /**
     * @param string $paymentId
     * @return PaymentInfoDTO
     * @throws ApiErrorException
     */
    public function validatePayment(string $paymentId): PaymentInfoDTO
    {
        $data = $this->stripe->paymentIntents->retrieve($paymentId);
        $result = ($data->toArray());

        return new PaymentInfoDTO(
            $this->getStatus($result['status']),
            PaymentSystem::STRIPE,
            $result['client_secret'],
            $result['id'],
            $result['amount_received'] / 100,
            $this->getCurrencyDTO($result['currency']),
            $result['created'],
            new PayerDTO(
                'Mark',
                null,
                null,
                null,
            )
        );
    }

    /**
     * @param MakePaymentDTO $makePaymentDTO
     * @return string
     * @throws ApiErrorException
     */
    public function createPayment(MakePaymentDTO $makePaymentDTO): string
    {
        $data = $this->stripe->paymentIntents->create([
            'amount'    => $makePaymentDTO->getAmount() * 100,
            'currency'  => $this->getCurrency($makePaymentDTO->getCurrency()),
        ]);

        $result = ['id' => $data->client_secret];

        return json_encode($result, true);
    }

    /**
     * @param Currency $currency
     * @return string
     */
    private function getCurrency(Currency $currency): string
    {
        return match ($currency) {
            Currency::USD => 'usd',
            Currency::EUR => 'eur',
        };
    }

    /**
     * @param string $currency
     * @return Currency
     */
    private function getCurrencyDTO(string $currency): Currency
    {
        return match ($currency) {
            'usd'   => Currency::USD,
            default => Currency::EUR,
        };
    }

    /**
     * @param string $status
     * @return TransactionStatus
     */
    private function getStatus(string $status): TransactionStatus
    {
        return match ($status) {
            'succeeded' => TransactionStatus::SUCCESS,
            default     => TransactionStatus::FAILED
        };
    }
}
