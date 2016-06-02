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
        "/democheckout/thanks",
        "/democheckout/card",
        "/democheckout/payneteasyresponse"
    ];
}
