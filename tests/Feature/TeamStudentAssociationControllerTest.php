<?php

use App\Models\Student;
use App\Models\Team;
use App\Models\TeamStudentAssociation;
use App\Models\User;

it('can add a student to a team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $student = Student::factory()->create();

    $response = $this->postJson("/api/team/{$team->id}/students", [
        'student_id' => $student->id,
    ], [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertSuccessful();
    $this->assertDatabaseHas('team_student_associations', [
        'team_id' => $team->id,
        'student_id' => $student->id,
    ]);
});

it('can remove a student from a team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $student = Student::factory()->create();
    TeamStudentAssociation::factory()->create([
        'team_id' => $team->id,
        'student_id' => $student->id,
    ]);

    $response = $this->deleteJson("/api/team/{$team->id}/students/$student->id", [], [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertStatus(204);
});

it('can list students by team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $student = Student::factory()->create();
    TeamStudentAssociation::factory()->create([
        'team_id' => $team->id,
        'student_id' => $student->id,
    ]);

    $response = $this->getJson("/api/team/{$team->id}/students", [
        'Authorization' => 'Bearer '.$user->createToken('auth_token')->plainTextToken,
    ]);

    $response->assertSuccessful();
    $response->assertJsonCount(1);
});
