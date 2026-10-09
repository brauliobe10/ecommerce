<?php

use App\Livewire\Pedidos\Index;
use App\Livewire\Ventas\Create;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Livewire\Livewire;

test('guests are redirected to the login page on the orders listing', function () {
    $this->get(route('pedidos.index'))->assertRedirect(route('login'));
});

test('authenticated users can visit the orders listing', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('pedidos.index'))->assertOk();
});

test('authenticated users can visit an order detail', function () {
    $user = User::factory()->create();

    $cliente = Cliente::create(['nombre' => 'Juan Perez']);

    $pedido = Pedido::create([
        'cliente_id' => $cliente->id,
        'nombre_cliente' => 'Juan Perez',
        'telefono' => '3001234567',
        'total' => 100,
        'estado' => Pedido::ESTADO_PENDIENTE,
    ]);

    $this->actingAs($user)->get(route('pedidos.show', $pedido))
        ->assertOk()
        ->assertSee('Juan Perez');
});

test('a pending order can be cancelled', function () {
    $this->actingAs(User::factory()->create());

    $pedido = Pedido::create([
        'nombre_cliente' => 'Juan Perez',
        'telefono' => '3001234567',
        'total' => 100,
        'estado' => Pedido::ESTADO_PENDIENTE,
    ]);

    $this->patch(route('pedidos.cancelar', $pedido))
        ->assertRedirect(route('pedidos.show', $pedido));

    expect($pedido->fresh()->estado)->toBe(Pedido::ESTADO_CANCELADO);
});

test('a confirmed order cannot be cancelled', function () {
    $this->actingAs(User::factory()->create());

    $pedido = Pedido::create([
        'nombre_cliente' => 'Juan Perez',
        'telefono' => '3001234567',
        'total' => 100,
        'estado' => Pedido::ESTADO_CONFIRMADO,
    ]);

    $this->patch(route('pedidos.cancelar', $pedido))
        ->assertRedirect(route('pedidos.show', $pedido))
        ->assertSessionHas('error');
});

test('confirming an order from POS creates a sale and decrements stock', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $cliente = Cliente::create(['nombre' => 'Juan Perez']);
    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    $pedido = Pedido::create([
        'cliente_id' => $cliente->id,
        'nombre_cliente' => 'Juan Perez',
        'telefono' => '3001234567',
        'total' => 150,
        'estado' => Pedido::ESTADO_PENDIENTE,
    ]);
    $pedido->detallePedidos()->create([
        'producto_id' => $producto->id,
        'cantidad' => 3,
        'precio_unitario' => 50,
        'subtotal' => 150,
    ]);

    Livewire::test(Create::class, ['pedidoId' => $pedido->id])
        ->set('metodo_pago', Venta::METODO_EFECTIVO)
        ->call('store')
        ->assertHasNoErrors();

    $venta = Venta::first();

    expect(Venta::count())->toBe(1);
    expect((float) $venta->total)->toBe(150.0);
    expect($producto->fresh()->stock)->toBe(7);
    expect($pedido->fresh()->estado)->toBe(Pedido::ESTADO_CONFIRMADO);
    expect($pedido->fresh()->venta_id)->toBe($venta->id);
});

test('orders can be filtered by state', function () {
    $this->actingAs(User::factory()->create());

    $pendiente = Pedido::create([
        'nombre_cliente' => 'Juan Perez',
        'telefono' => '3001234567',
        'total' => 100,
        'estado' => Pedido::ESTADO_PENDIENTE,
    ]);

    $cancelado = Pedido::create([
        'nombre_cliente' => 'Ana Diaz',
        'telefono' => '3007654321',
        'total' => 50,
        'estado' => Pedido::ESTADO_CANCELADO,
    ]);

    Livewire::test(Index::class)
        ->set('estado', Pedido::ESTADO_CANCELADO)
        ->assertViewHas('pedidos', fn ($pedidos) => $pedidos->total() === 1 && $pedidos->first()->id === $cancelado->id);

    Livewire::test(Index::class)
        ->set('estado', Pedido::ESTADO_PENDIENTE)
        ->assertViewHas('pedidos', fn ($pedidos) => $pedidos->total() === 1 && $pedidos->first()->id === $pendiente->id);
});
