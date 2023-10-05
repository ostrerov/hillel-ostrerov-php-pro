<?php

namespace App\Services\PaymentSystems\Stripe;

use App\Services\PaymentSystems\DTO\CreateTokenDTO;

use Exception;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class CreateTokenService
{
    public function __construct(
        protected StripeClient $stripe,
    ) {
    }

    /**
     * @param CreateTokenDTO $createTokenDTO
     * @return array
     */
    public function createToken(CreateTokenDTO $createTokenDTO): array
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $createTokenDTO->getCardNumber(),
                    'exp_month' => $createTokenDTO->getMonth(),
                    'exp_year' => $createTokenDTO->getYear(),
                    'cvc' => $createTokenDTO->getCvc(),
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }

        return $token;
    }
}
