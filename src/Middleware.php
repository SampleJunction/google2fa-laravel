<?php

namespace PragmaRX\Google2FALaravel;

use Closure;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Middleware
{
    public function handle($request, Closure $next)
    {
        $authenticator = app(Authenticator::class)->boot($request);
        $user = auth()->user();
        if ($authenticator->isAuthenticated()) {
            $user->two_fact_confirm = 1;
            $user->save();
            return $next($request);
        }
        return $authenticator->makeRequestOneTimePasswordResponse();
    }
}
