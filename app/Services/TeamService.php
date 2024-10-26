<?php

namespace App\Services;

use App\Models\Team;
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
     * @return Team The newly created team.
     */
    public function createTeam(Request $request): Team
    {
        return Team::create($request->all());
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
}
