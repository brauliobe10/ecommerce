<?php

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\User;

function crearClienteConCuenta(array $attributes = []): array
{
    $user = User::factory()->cliente()->create($attributes);

    $cliente = Cliente::create([
        'user_id' => $user->id,
        'nombre' => $user->name,
        'email' => $user->email,
    ]);

    return [$user, $cliente];
}

function crearPedido(Cliente $cliente, array $attributes = []): Pedido
{
    return Pedido::create([
        'cliente_id' => $cliente->id,
        'nombre_cliente' => $cliente->nombre,
        'telefono' => '3001234567',
        'email' => $cliente->email,
        'total' => 100,
        'estado' => Pedido::ESTADO_PENDIENTE,
        ...$attributes,
    ]);
}

test('guests are redirected to login from the customer portal', function () {
    $this->get(route('cliente.cuenta'))->assertRedirect(route('login'));
    $this->get(route('cliente.pedidos.index'))->assertRedirect(route('login'));
});

test('a customer can visit their account and order history', function () {
    [$user, $cliente] = crearClienteConCuenta(['name' => 'Ana Cliente']);

    $pedido = crearPedido($cliente);

    $this->actingAs($user)
        ->get(route('cliente.cuenta'))
        ->assertOk()
        ->assertSee('Mi cuenta')
        ->assertSee('Ana Cliente');

    $this->actingAs($user)
        ->get(route('cliente.pedidos.index'))
        ->assertOk()
        ->assertSee('Mis pedidos')
        ->assertSee(route('cliente.pedidos.show', $pedido));
});

test('a customer is redirected away from the admin dashboard', function () {
    [$user] = crearClienteConCuenta();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('cliente.cuenta'));
});

test('a customer cannot access staff modules', function () {
    [$user] = crearClienteConCuenta();

    $this->actingAs($user)
        ->get(route('productos.index'))
        ->assertRedirect(route('cliente.cuenta'));

    $this->actingAs($user)
        ->get(route('pedidos.index'))
        ->assertRedirect(route('cliente.cuenta'));

    $this->actingAs($user)
        ->get(route('ventas.index'))
        ->assertRedirect(route('cliente.cuenta'));

    $this->actingAs($user)
        ->get(route('usuarios.index'))
        ->assertRedirect(route('cliente.cuenta'));
});

test('a customer only sees their own orders', function () {
    [$user, $cliente] = crearClienteConCuenta();
    [, $otroCliente] = crearClienteConCuenta(['name' => 'Otro Cliente']);

    $propio = crearPedido($cliente, ['total' => 50]);
    $ajeno = crearPedido($otroCliente, ['total' => 999]);

    $this->actingAs($user)
        ->get(route('cliente.pedidos.index'))
        ->assertOk()
        ->assertSee(route('cliente.pedidos.show', $propio))
        ->assertDontSee(route('cliente.pedidos.show', $ajeno));
});

test('a customer cannot view another customer order', function () {
    [$user] = crearClienteConCuenta();
    [, $otroCliente] = crearClienteConCuenta(['name' => 'Otro Cliente']);

    $ajeno = crearPedido($otroCliente);

    $this->actingAs($user)
        ->get(route('cliente.pedidos.show', $ajeno))
        ->assertForbidden();
});

test('a customer can cancel their own pending order', function () {
    [$user, $cliente] = crearClienteConCuenta();
    $pedido = crearPedido($cliente);

    $this->actingAs($user)
        ->patch(route('cliente.pedidos.cancelar', $pedido))
        ->assertRedirect(route('cliente.pedidos.show', $pedido));

    expect($pedido->fresh()->estado)->toBe(Pedido::ESTADO_CANCELADO);
});

test('a customer cannot cancel a confirmed order', function () {
    [$user, $cliente] = crearClienteConCuenta();
    $pedido = crearPedido($cliente, ['estado' => Pedido::ESTADO_CONFIRMADO]);

    $this->actingAs($user)
        ->patch(route('cliente.pedidos.cancelar', $pedido))
        ->assertRedirect(route('cliente.pedidos.show', $pedido))
        ->assertSessionHas('error');

    expect($pedido->fresh()->estado)->toBe(Pedido::ESTADO_CONFIRMADO);
});

test('a customer cannot cancel another customer order', function () {
    [$user] = crearClienteConCuenta();
    [, $otroCliente] = crearClienteConCuenta(['name' => 'Otro Cliente']);
    $ajeno = crearPedido($otroCliente);

    $this->actingAs($user)
        ->patch(route('cliente.pedidos.cancelar', $ajeno))
        ->assertForbidden();

    expect($ajeno->fresh()->estado)->toBe(Pedido::ESTADO_PENDIENTE);
});

test('a customer is redirected to their account after login', function () {
    $user = User::factory()->cliente()->create();

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('cliente.cuenta'));

    $this->assertAuthenticatedAs($user);
});

test('a registered customer can see guest orders with the same email', function () {
    $pedido = Pedido::create([
        'nombre_cliente' => 'Invitada',
        'telefono' => '3001234567',
        'email' => 'invitada@example.com',
        'total' => 75,
        'estado' => Pedido::ESTADO_PENDIENTE,
    ]);

    $this->post(route('register.store'), [
        'name' => 'Invitada',
        'email' => 'invitada@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('cliente.cuenta'));

    $user = User::where('email', 'invitada@example.com')->firstOrFail();

    expect($user->role)->toBe(User::ROLE_CLIENTE);
    expect($user->cliente)->not->toBeNull();
    expect($pedido->fresh()->cliente_id)->toBe($user->cliente->id);
});
