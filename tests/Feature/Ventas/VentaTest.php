<?php

use App\Livewire\Ventas\Create;
use App\Livewire\Ventas\Index;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Livewire\Livewire;

test('guests are redirected to the login page', function () {
    $this->get(route('ventas.index'))->assertRedirect(route('login'));
});

test('authenticated users can visit the sales history', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('ventas.index'))->assertOk();
});

test('authenticated users can visit the sale registration page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('ventas.create'))->assertOk();
});

test('a sale can be registered and decreases product stock', function () {
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

    Livewire::test(Create::class)
        ->set('cliente_id', (string) $cliente->id)
        ->set('metodo_pago', Venta::METODO_EFECTIVO)
        ->set('items.0.producto_id', (string) $producto->id)
        ->set('items.0.cantidad', '3')
        ->call('store')
        ->assertHasNoErrors();

    expect(Venta::count())->toBe(1);
    expect($producto->fresh()->stock)->toBe(7);

    $venta = Venta::first();
    expect((float) $venta->total)->toBe(150.0);
    expect($venta->cliente_id)->toBe($cliente->id);
    expect($venta->usuario_id)->toBe($user->id);
    expect($venta->detalleVentas)->toHaveCount(1);
});

test('a sale with insufficient stock is rejected', function () {
    $this->actingAs(User::factory()->create());

    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 2,
        'activo' => true,
    ]);

    Livewire::test(Create::class)
        ->set('items.0.producto_id', (string) $producto->id)
        ->set('items.0.cantidad', '5')
        ->call('store')
        ->assertHasErrors('items');

    expect(Venta::count())->toBe(0);
    expect($producto->fresh()->stock)->toBe(2);
});

test('a sale can be cancelled and restores product stock', function () {
    $this->actingAs(User::factory()->create());

    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    $venta = Venta::create([
        'usuario_id' => User::first()->id,
        'fecha_venta' => now(),
        'total' => 100,
        'metodo_pago' => Venta::METODO_EFECTIVO,
        'estado' => Venta::ESTADO_COMPLETADA,
    ]);
    $venta->detalleVentas()->create([
        'producto_id' => $producto->id,
        'cantidad' => 2,
        'precio_unitario' => 50,
        'subtotal' => 100,
    ]);
    $producto->update(['stock' => 8]);

    $this->post(route('ventas.anular', $venta))
        ->assertRedirect(route('ventas.show', $venta));

    expect($venta->fresh()->estado)->toBe(Venta::ESTADO_ANULADA);
    expect($producto->fresh()->stock)->toBe(10);
});

test('sales can be filtered by state and method of payment', function () {
    $this->actingAs(User::factory()->create());

    $usuarioId = User::first()->id;

    $completada = Venta::create([
        'usuario_id' => $usuarioId,
        'fecha_venta' => now(),
        'total' => 100,
        'metodo_pago' => Venta::METODO_EFECTIVO,
        'estado' => Venta::ESTADO_COMPLETADA,
    ]);

    $anulada = Venta::create([
        'usuario_id' => $usuarioId,
        'fecha_venta' => now(),
        'total' => 50,
        'metodo_pago' => Venta::METODO_TARJETA,
        'estado' => Venta::ESTADO_ANULADA,
    ]);

    Livewire::test(Index::class)
        ->set('estado', Venta::ESTADO_ANULADA)
        ->assertViewHas('ventas', fn ($ventas) => $ventas->total() === 1 && $ventas->first()->id === $anulada->id);

    Livewire::test(Index::class)
        ->set('metodo_pago', Venta::METODO_EFECTIVO)
        ->assertViewHas('ventas', fn ($ventas) => $ventas->total() === 1 && $ventas->first()->id === $completada->id);
});
