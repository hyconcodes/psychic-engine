<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Laravel\Fortify\Features;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'username' => 'johndoe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'username' => 'johndoe',
        'email' => 'test@example.com',
    ]);
});

test('registration rejects usernames longer than eight characters', function () {
    $response = $this->from(route('register'))->post(route('register.store'), [
        'name' => 'John Doe',
        'username' => 'johndoe12',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('register'))
        ->assertSessionHasErrors('username');

    $this->assertDatabaseMissing('users', ['username' => 'johndoe12']);
});

test('registration rejects usernames already in use', function () {
    User::factory()->create(['username' => 'existing']);

    $response = $this->from(route('register'))->post(route('register.store'), [
        'name' => 'John Doe',
        'username' => 'existing',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('register'))
        ->assertSessionHasErrors('username');

    $this->assertDatabaseCount('users', 1);
});
