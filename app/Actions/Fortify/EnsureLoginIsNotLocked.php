<?php

namespace App\Actions\Fortify;

use Closure;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class EnsureLoginIsNotLocked
{
    public const MAX_ATTEMPTS = 3;

    public const LOCKOUT_SECONDS = 600;

    /**
     * Session key that stores the Unix timestamp until which the login is locked.
     */
    public const SESSION_KEY = 'login_bloqueado_hasta';

    /**
     * Reject the login once the allowed number of failed attempts is reached.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $key = self::throttleKeyFor((string) $request->input(Fortify::username()), $request->ip());

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            event(new Lockout($request));

            $request->session()->put(
                self::SESSION_KEY,
                now()->addSeconds((int) RateLimiter::availableIn($key))->getTimestamp(),
            );

            return redirect()->route('login');
        }

        return $next($request);
    }

    /**
     * Storage key that groups the failed attempts by username and IP address.
     */
    public static function throttleKeyFor(string $username, ?string $ip): string
    {
        return 'lockout-login:'.Str::transliterate(Str::lower($username).'|'.$ip);
    }
}
