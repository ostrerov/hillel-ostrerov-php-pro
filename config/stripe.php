<?php

    return [
        'api_keys' => [
            'public_key' => env('STRIPE_PUBLICABLE_KEY'),
            'secret_key' => env('STRIPE_SECRET_KEY'),
        ]
    ];
