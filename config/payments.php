<?php

use App\Payment\BrainTreePayment;
use App\Payment\CreditCardPayment;
use App\Payment\PayPalPayment;
use App\Payment\WireTransferPayment;
use App\Services\CreditCardPaymentStatusService;
use App\Services\PayPalPaymentStatusService;
use App\Services\WireTransferPaymentStatusService;

return [
    'gateways' => [
        'PayPal' => PayPalPayment::class,
        'Credit Card' => CreditCardPayment::class,
        'BrainTree' => BrainTreePayment::class,
        'Wire Transfer' => WireTransferPayment::class,
    ],

    'default_gateway' => 'Wire Transfer',

    'status_services' => [
        'PayPal' => PayPalPaymentStatusService::class,
        'Credit Card' => CreditCardPaymentStatusService::class,
        'BrainTree' => CreditCardPaymentStatusService::class,
        'Wire Transfer' => WireTransferPaymentStatusService::class,
    ],

    'default_status_gateway' => 'Wire Transfer',
];
