<?php

use App\Models\Student;

it('lists students', function () {
    Student::factory(10)->create();

    $response = $this->get('/api/student');

    $response->assertStatus(200)
        ->assertJsonCount(10);
});

it('creates a student', function () {
    $student = Student::factory()->make();

    $response = $this->postJson('/api/student', $student->toArray());

    $response->assertStatus(201)
        ->assertJson($student->toArray());
});

it('updates a student', function () {
    $student = Student::factory()->create();
    $newStudent = Student::factory()->make();

    $response = $this->patchJson('/api/student/'.$student->id, $newStudent->toArray());

    $response->assertStatus(200);
});

it('deletes a student', function () {
    $student = Student::factory()->create();

    $response = $this->deleteJson('/api/student/'.$student->id);

    $response->assertStatus(204);
});
