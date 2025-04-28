<?php

namespace Illuminate\Foundation\Http\Middleware;

/**
 * Alias of VerifyCsrfToken for consistency.
 */
class ValidateCsrfToken extends VerifyCsrfToken
{
    protected $except = [
        // Authentification
        'mutuelle/login',
        'mutuelle/register',

        // CRUD mutuelles
        'mutuelle',           // POST
        'mutuelles/*',         // PUT / DELETE / autres actions dynamiques
    ];
}
