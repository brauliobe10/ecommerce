<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\EnsureLoginIsNotLocked;
use App\Actions\Fortify\ResetUserPassword;
use App\Http\Responses\LoginResponse;
use App\Http\Responses\RegisterResponse;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
        $this->configureLoginLockout();
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn () => view('pages::auth.login'));
        Fortify::registerView(fn () => view('pages::auth.register'));
        Fortify::resetPasswordView(fn () => view('pages::auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('pages::auth.forgot-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }

    /**
     * Lock the login for 10 minutes after 3 failed password attempts (per email + IP).
     *
     * Attempts are counted only when authentication fails, so successful logins
     * never consume the limit. Each failure flashes the remaining attempts to
     * the login screen, and a successful login resets the counter.
     */
    private function configureLoginLockout(): void
    {
        Fortify::authenticateThrough(fn (Request $request): array => [
            config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
            EnsureLoginIsNotLocked::class,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]);

        Event::listen(function (Failed $event): void {
            $request = request();

            if (! $request->hasSession()) {
                return;
            }

            $username = (string) ($event->credentials[Fortify::username()] ?? '');
            $key = EnsureLoginIsNotLocked::throttleKeyFor($username, $request->ip());

            $attempts = RateLimiter::hit($key, EnsureLoginIsNotLocked::LOCKOUT_SECONDS);
            $remaining = EnsureLoginIsNotLocked::MAX_ATTEMPTS - $attempts;

            if ($remaining > 0) {
                session()->flash('intentos_restantes', $remaining);
            } else {
                $request->session()->put(
                    EnsureLoginIsNotLocked::SESSION_KEY,
                    now()->addSeconds((int) RateLimiter::availableIn($key))->getTimestamp(),
                );
            }
        });

        Event::listen(function (Login $event): void {
            $request = request();

            if (! $request->hasSession()) {
                return;
            }

            $request->session()->forget(EnsureLoginIsNotLocked::SESSION_KEY);

            RateLimiter::clear(EnsureLoginIsNotLocked::throttleKeyFor(
                (string) $request->input(Fortify::username()),
                $request->ip(),
            ));
        });
    }
}
