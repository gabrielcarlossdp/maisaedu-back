<?php

use App\Models\Team;
use App\Models\User;

it('lists teams', function () {
    $user = User::factory()->create();
    Team::factory(10)->create();

    $response = $this->get('/api/team', [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('creates a team', function () {
    $user = User::factory()->create();

    $team = Team::factory()->make();

    $response = $this->postJson('/api/team', $team->toArray(), [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(201)
        ->assertJson($team->toArray());
});

it('updates a team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $newTeam = Team::factory()->make();

    $response = $this->patchJson('/api/team/'.$team->id, $newTeam->toArray(), [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(200);
});

it('deletes a team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $response = $this->deleteJson('/api/team/'.$team->id, [], [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(204);
});
