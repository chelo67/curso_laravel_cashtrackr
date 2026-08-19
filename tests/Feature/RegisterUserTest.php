<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;

uses(RefreshDatabase::class);

test('shows the registration screen', function () {

    $response = $this->get(route('register'));

    $response->assertOk();

    $response->assertStatus(200);
    $response->assertSee('Crear Cuenta');
});

test('register a new user as unverified and dispatches the registered event', function() {

    Event::fake();

    $response = $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'Juan@correo.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('verification.notice'));

    $user = \App\Models\User::where('email', 'Juan@correo.com')->first();

    expect($user)->not()->toBeNull();
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('Juan@correo.com');
    expect($user->hasVerifiedEmail())->toBeFalse();

    Event::assertDispatched(Registered::class);
     
});

test('should validate required fields when the request body is empty', function () {
    
    $response = $this->post(route('register.store'), []);

    $response->assertSessionHasErrors(['name', 'email', 'password']);

    $response->assertSessionHasErrors([
        'name' => 'El Nombre es obligatorio',
        'email' => 'El E-mail es obligatorio',
        'password' => 'La Contraseña es obligatorio',
    ]);

});