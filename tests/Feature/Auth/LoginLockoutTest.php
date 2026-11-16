<?php

use App\Actions\Fortify\EnsureLoginIsNotLocked;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

test('a failed login shows the remaining attempts on the login screen', function () {
    $user = User::factory()->create();

    $response = $this->from(route('login'))
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

    $response
        ->assertOk()
        ->assertSee('Te quedan 2 intentos');

    $this->assertGuest();
});

test('the third failed password attempt locks the login for 10 minutes', function () {
    $user = User::factory()->create();
    $key = EnsureLoginIsNotLocked::throttleKeyFor($user->email, '127.0.0.1');

    $this->from(route('login'))->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);
    $this->from(route('login'))->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response = $this->from(route('login'))
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

    $response
        ->assertOk()
        ->assertSee('El inicio de sesión está bloqueado')
        ->assertSee('disabled');

    $this->assertGuest();
});

test('a locked user cannot log in even with correct credentials', function () {
    $user = User::factory()->create();

    foreach (range(1, 3) as $i) {
        $this->from(route('login'))->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
    }

    $response = $this->from(route('login'))
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

    $response
        ->assertOk()
        ->assertSee('El inicio de sesión está bloqueado');

    $this->assertGuest();
});

test('a successful login resets the failed attempt counter', function () {
    $user = User::factory()->create();
    $key = EnsureLoginIsNotLocked::throttleKeyFor($user->email, '127.0.0.1');

    $this->from(route('login'))->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);
    $this->from(route('login'))->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    expect(RateLimiter::attempts($key))->toBe(2);

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect();

    expect(RateLimiter::attempts($key))->toBe(0);
});
