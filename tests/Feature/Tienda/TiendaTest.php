<?php

use App\Livewire\Tienda\Carrito;
use App\Livewire\Tienda\Catalogo;
use App\Livewire\Tienda\Checkout;
use App\Models\Pedido;
use App\Models\Producto;
use App\Services\Carrito\CarritoService;
use Livewire\Livewire;

test('the store home page shows the catalog', function () {
    Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Catálogo')
        ->assertSee('Cafe');
});

test('the product detail page is visible for active products', function () {
    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    $this->get(route('tienda.producto', $producto))
        ->assertOk()
        ->assertSee('Cafe')
        ->assertSee('Agregar al carrito');
});

test('the product detail page redirects home for inactive products', function () {
    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => false,
    ]);

    $this->get(route('tienda.producto', $producto))->assertRedirect(route('home'));
});

test('a product can be added to the cart from the catalog', function () {
    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    Livewire::test(Catalogo::class)
        ->call('addToCart', $producto->id);

    expect(app(CarritoService::class)->count())->toBe(1);
    expect(app(CarritoService::class)->subtotal())->toBe(50.0);
});

test('the cart cannot exceed the available stock', function () {
    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 3,
        'activo' => true,
    ]);

    app(CarritoService::class)->add($producto->id, 5);

    expect(app(CarritoService::class)->count())->toBe(3);
});

test('a checkout creates a pending order without touching stock', function () {
    config()->set('services.whatsapp.number', '573001234567');

    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    app(CarritoService::class)->add($producto->id, 2);

    Livewire::test(Checkout::class)
        ->set('nombre', 'Juan Perez')
        ->set('telefono', '3001234567')
        ->call('confirmar')
        ->assertHasNoErrors();

    $pedido = Pedido::first();

    expect(Pedido::count())->toBe(1);
    expect($pedido->nombre_cliente)->toBe('Juan Perez');
    expect($pedido->telefono)->toBe('3001234567');
    expect($pedido->estado)->toBe(Pedido::ESTADO_PENDIENTE);
    expect((float) $pedido->total)->toBe(100.0);
    expect($pedido->detallePedidos)->toHaveCount(1);
    expect($producto->fresh()->stock)->toBe(10);
    expect(session('carrito'))->toBeNull();
});

test('the cart badge reflects the number of items', function () {
    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    app(CarritoService::class)->add($producto->id, 2);

    Livewire::test(Carrito::class)
        ->assertSet('cantidad', 2);
});
