<?php

use App\Models\User;

it('can login', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);
});

it('can register', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'j@j.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);
});

it('can logout', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/logout', [], [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Logged out',
        ]);
});

it('can me', function () {
    $user = User::factory()->create();

    $response = $this->getJson('/api/me', [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);
});
