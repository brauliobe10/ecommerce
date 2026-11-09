<?php

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Carbon\CarbonImmutable;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('dashboard shows store metrics and recent activity', function () {
    $user = User::factory()->create(['name' => 'Laura']);
    $cliente = Cliente::create(['nombre' => 'Ana Pérez']);

    Producto::create([
        'nombre' => 'Teclado mecánico',
        'codigo' => 'TEC-001',
        'precio' => 49.90,
        'stock' => 2,
        'activo' => true,
    ]);

    Venta::create([
        'cliente_id' => $cliente->id,
        'usuario_id' => $user->id,
        'fecha_venta' => CarbonImmutable::now(),
        'total' => 150.50,
        'metodo_pago' => Venta::METODO_EFECTIVO,
        'estado' => Venta::ESTADO_COMPLETADA,
    ]);

    Pedido::create([
        'cliente_id' => $cliente->id,
        'nombre_cliente' => 'Ana Pérez',
        'telefono' => '555-1234',
        'total' => 80,
        'estado' => Pedido::ESTADO_PENDIENTE,
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard'));

    $response
        ->assertOk()
        ->assertSee('Bienvenido de nuevo, Laura')
        ->assertSee('Ingresos del mes')
        ->assertSee('$150.50')
        ->assertSee('Pedidos pendientes')
        ->assertSee('Clientes registrados')
        ->assertSee('Métodos de pago')
        ->assertSee('Pedidos recibidos')
        ->assertSee('Últimas ventas')
        ->assertSee('Ana Pérez')
        ->assertSee('Stock bajo')
        ->assertSee('Teclado mecánico')
        ->assertSee('data-dashboard-chart="ingresos"', false);

    preg_match('/data-chart=\'([^\']+)\'/', (string) $response->getContent(), $matches);

    $chartData = json_decode($matches[1] ?? '', true);

    expect($chartData)
        ->toBeArray()
        ->toHaveKeys(['labels', 'actual', 'anterior']);
});

test('dashboard accepts a six month chart period', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard', ['meses' => 6]));

    $response->assertOk()
        ->assertSee('Últimos 6 meses')
        ->assertSee('6M');
});

test('dashboard falls back to twelve months for an invalid period', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard', ['meses' => 99]));

    $response->assertOk()
        ->assertSee('Últimos 12 meses');
});
