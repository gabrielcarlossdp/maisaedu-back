<?php

use App\Models\Student;
use App\Models\User;

it('lists students', function () {
    $user = User::factory()->create();
    Student::factory(10)->create();

    $response = $this->get('/api/student', [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('creates a student', function () {
    $user = User::factory()->create();

    $student = Student::factory()->make();

    $response = $this->postJson('/api/student', $student->toArray(), [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(201)
        ->assertJson($student->toArray());
});

it('updates a student', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();
    $newStudent = Student::factory()->make();

    $response = $this->patchJson('/api/student/'.$student->id, $newStudent->toArray(), [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(200);
});

it('deletes a student', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $response = $this->deleteJson('/api/student/'.$student->id, [], [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(204);
});
