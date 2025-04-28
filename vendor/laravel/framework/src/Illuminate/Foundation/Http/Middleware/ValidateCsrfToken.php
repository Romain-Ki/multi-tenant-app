<?php

namespace Illuminate\Foundation\Http\Middleware;

/**
 * Alias of VerifyCsrfToken for consistency.
 */
class ValidateCsrfToken extends VerifyCsrfToken
{
    protected $except = [
        // Authentification
//        'mutuelle/login',
//        'mutuelle/register',

        'mutuelle',
        'mutuelles/*',
        'client/*',
        'clients/*',
    ];
}
