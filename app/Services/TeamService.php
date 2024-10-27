<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Team;
use App\Models\TeamStudentAssociation;
use App\Traits\CustomQueryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TeamService
{
    use CustomQueryTrait;

    /**
     * Retrieves a list of teams based on the request parameters.
     *
     * @param  Request  $request  The request containing filter, search, sort, and pagination parameters.
     * @return Collection|LengthAwarePaginator The filtered, searched, ordered, and paginated list of teams.
     */
    public function getTeams(Request $request): Collection|LengthAwarePaginator
    {
        return $this->cfilterSeachOrderPaginate(Team::query(), $request, [
            'name',
            'description',
            'creator_id',
        ]);
    }

    /**
     * Creates a new team from the given request parameters.
     *
     * @param  Request  $request  The request containing the team's information.
     * @param  int  $userId  The ID of the user who created the team.
     * @return Team The newly created team.
     */
    public function createTeam(Request $request, int $userId): Team
    {
        return Team::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'creator_id' => $userId,
        ]);
    }

    /**
     * Retrieves a team by its ID.
     *
     * @param  int  $id  The team's ID.
     * @return Team|null The team with the given ID, or null if not found.
     */
    public function getTeam(int $id): ?Team
    {
        return Team::find($id);
    }

    /**
     * Updates a team by its ID.
     *
     * @param  Request  $request  The request containing the updated team's information.
     * @param  int  $id  The team's ID.
     * @return Team The updated team.
     */
    public function updateTeam(Request $request, int $id): Team
    {
        $team = Team::find($id);
        $team->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return $team;
    }

    /**
     * Deletes a team by its ID.
     *
     * @param  int  $id  The team's ID.
     * @return Team|null The deleted team, or null if not found.
     */
    public function deleteTeam(int $id): ?Team
    {
        $team = Team::find($id);
        $team->delete();

        return $team;
    }

    /**
     * Retrieves a list of students associated with a given team.
     *
     * @param  int  $id  The team's ID.
     * @return Collection|LengthAwarePaginator The filtered, searched, ordered, and paginated list of students.
     */
    public function listStudentsByTeam(int $id): Collection|LengthAwarePaginator
    {
        $students = Student::whereHas('associations', function ($query) use ($id) {
            $query->where('team_id', $id);
        });

        return $this->cfilterSeachOrderPaginate($students, request(), [
            'name',
            'email',
            'cpf',
            'ra',
        ]);
    }

    /**
     * Adds a student to a team.
     *
     * @param  Request  $request  The request containing the student's ID.
     * @param  int  $teamId  The team's ID.
     * @return TeamStudentAssociation The created association.
     */
    public function addStudentToTeam(Request $request, int $teamId): TeamStudentAssociation
    {
        $association = TeamStudentAssociation::updateOrCreate([
            'team_id' => $teamId,
            'student_id' => $request->input('student_id'),
        ],[
            'team_id' => $teamId,
            'student_id' => $request->input('student_id'),
        ]);

        return $association;
    }

    /**
     * Removes a student from a team.
     *
     * @param  int  $studentId  The student's ID.
     * @param  int  $teamId  The team's ID.
     * @return TeamStudentAssociation|null The deleted association, or null if not found.
     */
    public function removeStudentFromTeam(int $studentId, int $teamId): ?TeamStudentAssociation
    {
        $association = TeamStudentAssociation::where('team_id', $teamId)
            ->where('student_id', $studentId)
            ->first();

        if ($association) {
            $association->delete();
        }

        return $association;
    }
}
