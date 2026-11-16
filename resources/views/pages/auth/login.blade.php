<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Intentos fallidos -->
        @php
            $bloqueadoHasta = (int) session('login_bloqueado_hasta');
            $bloqueadoSegundos = $bloqueadoHasta > 0 ? max(0, $bloqueadoHasta - time()) : 0;

            if ($bloqueadoHasta > 0 && $bloqueadoSegundos === 0) {
                session()->forget('login_bloqueado_hasta');
            }
        @endphp

        @if ($bloqueadoSegundos > 0)
            <div id="login-bloqueado" class="ui-alert-error" role="alert">
                <span>Has superado el número de intentos permitidos. El inicio de sesión está bloqueado; vuelve a intentarlo en <span data-restante>{{ $bloqueadoSegundos >= 60 ? ceil($bloqueadoSegundos / 60).' minutos' : $bloqueadoSegundos.' segundos' }}</span>.</span>
            </div>
        @elseif (session('intentos_restantes'))
            <div class="ui-alert-warning" role="alert">
                <span>Credenciales incorrectas. {{ ($intentosRestantes = (int) session('intentos_restantes')) === 1 ? 'Te queda 1 intento' : 'Te quedan '.$intentosRestantes.' intentos' }} antes de que el acceso se bloquee por 10 minutos.</span>
            </div>
        @endif

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />


        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <button type="submit" class="ui-btn-primary w-full justify-center @if ($bloqueadoSegundos > 0)cursor-not-allowed opacity-50 @endif" data-test="login-button" @disabled($bloqueadoSegundos > 0)>
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>

        @if ($bloqueadoSegundos > 0)
            <script>
                (() => {
                    let restante = @js($bloqueadoSegundos);
                    const alerta = document.getElementById('login-bloqueado');
                    const cuenta = document.querySelector('[data-restante]');
                    const boton = document.querySelector('[data-test="login-button"]');

                    const temporizador = setInterval(() => {
                        restante--;

                        if (restante <= 0) {
                            clearInterval(temporizador);
                            alerta?.remove();

                            if (boton) {
                                boton.disabled = false;
                            }

                            return;
                        }

                        if (cuenta) {
                            cuenta.textContent = restante >= 60 ? Math.ceil(restante / 60) + ' minutos' : restante + ' segundos';
                        }
                    }, 1000);
                })();
            </script>
        @endif
    </div>
</x-layouts::auth>
