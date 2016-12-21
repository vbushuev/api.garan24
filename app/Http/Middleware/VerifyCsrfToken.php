<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "/",
        "/processpay",
        "/payout",
        "/checkout",
        "/payoutresponse",
        "/payoutcallback",
        "/magnitolkin/payneteasyresponse",
        "/magnitolkin/personal",
        "/magnitolkin/deliverypaymethod",
        "/magnitolkin/checkout",
        "/democheckout",
        "/democheckout/checkout",
        "/democheckout/personal",
        "/democheckout/deliverypaymethod",
        "/democheckout/passport",
        "/democheckout/thanks",
        "/democheckout/card",
        "/democheckout/payneteasyresponse",
        "/checkout",
        "/checkout/checkout",
        "/checkout/personal",
        "/checkout/deliverypaymethod",
        "/checkout/deliverymethod",
        "/checkout/address",
        "/checkout/passport",
        "/checkout/thanks",
        "/checkout/card",
        "/checkout/payout",
        "/checkout/payoutresponse",
        "/checkout/payment",
        "/personal",
        "/deliverypaymethod",
        "deliverypaymethod",
        "/deliverymethod",
        "/address",
        "/passport",
        "/thanks",
        "/card",
        "/payout",
        "/payoutresponse",
        "/payment",
        "/shipping/bb",
        "/crd",
        "/cart/parseproduct",
        "/prod",
        "/prod/create",
        "/prod/create/s",
    ];
}
