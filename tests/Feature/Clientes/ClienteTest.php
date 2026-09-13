<?php

use App\Livewire\Clientes\Index as ClientesIndex;
use App\Models\Cliente;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected to the login page', function () {
    $this->get(route('clientes.index'))->assertRedirect(route('login'));
});

test('authenticated users can visit the customers list', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('clientes.index'))->assertOk();
});

test('authenticated users can create a customer', function () {
    $this->actingAs(User::factory()->create());

    $this->post(route('clientes.store'), [
        'nombre' => 'Maria Lopez',
        'email' => 'maria@example.com',
        'telefono' => '555-1234',
    ])->assertRedirect(route('clientes.index'));

    expect(Cliente::where('email', 'maria@example.com')->exists())->toBeTrue();
});

test('customers can be searched by name', function () {
    $this->actingAs(User::factory()->create());

    Cliente::create(['nombre' => 'Carlos Ruiz']);
    Cliente::create(['nombre' => 'Ana Torres']);

    Livewire::test(ClientesIndex::class)
        ->set('search', 'Carlos')
        ->assertSee('Carlos Ruiz')
        ->assertDontSee('Ana Torres');
});
