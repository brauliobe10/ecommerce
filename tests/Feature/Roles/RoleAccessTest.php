<?php

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;

test('an administrator can access all staff modules', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->get(route('dashboard'))->assertOk();
    $this->actingAs($admin)->get(route('usuarios.index'))->assertOk();
    $this->actingAs($admin)->get(route('clientes.index'))->assertOk();
    $this->actingAs($admin)->get(route('productos.index'))->assertOk();
    $this->actingAs($admin)->get(route('pedidos.index'))->assertOk();
    $this->actingAs($admin)->get(route('ventas.index'))->assertOk();
});

test('a seller can access everything except user management', function () {
    $vendedor = User::factory()->vendedor()->create();

    $this->actingAs($vendedor)->get(route('dashboard'))->assertOk();
    $this->actingAs($vendedor)->get(route('clientes.index'))->assertOk();
    $this->actingAs($vendedor)->get(route('productos.index'))->assertOk();
    $this->actingAs($vendedor)->get(route('pedidos.index'))->assertOk();
    $this->actingAs($vendedor)->get(route('ventas.index'))->assertOk();

    $this->actingAs($vendedor)->get(route('usuarios.index'))->assertForbidden();
});

test('a seller cannot create or delete staff users', function () {
    $vendedor = User::factory()->vendedor()->create();
    $otroAdmin = User::factory()->admin()->create();

    $this->actingAs($vendedor)
        ->post(route('usuarios.store'), [
            'name' => 'Nuevo',
            'email' => 'nuevo@example.com',
            'role' => 'vendedor',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertForbidden();

    $this->actingAs($vendedor)
        ->delete(route('usuarios.destroy', $otroAdmin))
        ->assertForbidden();
});

test('a seller does not see the users module link in the sidebar', function () {
    $vendedor = User::factory()->vendedor()->create();

    $this->actingAs($vendedor)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee(route('usuarios.index'));
});

test('a new staff user is created with the selected role', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('usuarios.store'), [
            'name' => 'Vendedor Nuevo',
            'email' => 'vendedor@example.com',
            'role' => User::ROLE_VENDEDOR,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('usuarios.index'));

    $usuario = User::where('email', 'vendedor@example.com')->firstOrFail();

    expect($usuario->role)->toBe(User::ROLE_VENDEDOR);
    expect($usuario->email_verified_at)->not->toBeNull();
});

test('an administrator can delete another administrator', function () {
    $admin = User::factory()->admin()->create();
    $otroAdmin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->delete(route('usuarios.destroy', $otroAdmin))
        ->assertRedirect(route('usuarios.index'));

    expect($otroAdmin->fresh())->toBeNull();
});

test('the last administrator cannot be demoted', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->put(route('usuarios.update', $admin), [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => User::ROLE_VENDEDOR,
        ])
        ->assertRedirect(route('usuarios.edit', $admin))
        ->assertSessionHasErrors('role');

    expect($admin->fresh()->role)->toBe(User::ROLE_ADMIN);
});

test('a user with sales cannot be deleted', function () {
    $admin = User::factory()->admin()->create();
    $vendedor = User::factory()->vendedor()->create();

    Venta::create([
        'usuario_id' => $vendedor->id,
        'fecha_venta' => now(),
        'total' => 50,
        'metodo_pago' => Venta::METODO_EFECTIVO,
        'estado' => Venta::ESTADO_COMPLETADA,
    ]);

    $this->actingAs($admin)
        ->delete(route('usuarios.destroy', $vendedor))
        ->assertRedirect(route('usuarios.index'))
        ->assertSessionHas('error');

    expect($vendedor->fresh())->not->toBeNull();
});

test('a product with sales cannot be deleted', function () {
    $admin = User::factory()->admin()->create();

    $producto = Producto::create([
        'nombre' => 'Cafe',
        'codigo' => 'CAF-001',
        'precio' => 50,
        'stock' => 10,
        'activo' => true,
    ]);

    $venta = Venta::create([
        'usuario_id' => $admin->id,
        'fecha_venta' => now(),
        'total' => 50,
        'metodo_pago' => Venta::METODO_EFECTIVO,
        'estado' => Venta::ESTADO_COMPLETADA,
    ]);

    $venta->detalleVentas()->create([
        'producto_id' => $producto->id,
        'cantidad' => 1,
        'precio_unitario' => 50,
        'subtotal' => 50,
    ]);

    $this->actingAs($admin)
        ->delete(route('productos.destroy', $producto))
        ->assertRedirect(route('productos.index'))
        ->assertSessionHas('error');

    expect($producto->fresh())->not->toBeNull();
});

test('a customer with orders cannot be deleted', function () {
    $admin = User::factory()->admin()->create();
    $cliente = Cliente::create(['nombre' => 'Cliente con pedido']);

    Pedido::create([
        'cliente_id' => $cliente->id,
        'nombre_cliente' => 'Cliente con pedido',
        'telefono' => '3001234567',
        'total' => 10,
        'estado' => Pedido::ESTADO_PENDIENTE,
    ]);

    $this->actingAs($admin)
        ->delete(route('clientes.destroy', $cliente))
        ->assertRedirect(route('clientes.index'))
        ->assertSessionHas('error');

    expect($cliente->fresh())->not->toBeNull();
});
