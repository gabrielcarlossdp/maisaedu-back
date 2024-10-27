<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class TeamController extends Controller
{
    public function __construct(protected TeamService $teamService) {}

    /**
     * Display a listing of the team.
     *
     * @OA\Get(
     *      path="/teams",
     *      summary="Get list of teams",
     *      tags={"Teams"},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(
     *               oneOf={
     *
     *                      @OA\Schema(ref="#/components/schemas/TeamPaginate"),
     *                      @OA\Schema(ref="#/components/schemas/Team")
     *             }
     *         )
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      ),
     *
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="integer",
     *              example=10
     *          )
     *      ),
     *
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="string",
     *              example="John"
     *          )
     *      ),
     *
     *      @OA\Parameter(
     *          name="order",
     *          in="query",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="string",
     *              example="name"
     *          )
     *      ),
     *
     *      @OA\Parameter(
     *          name="order_by",
     *          in="query",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="string",
     *              example="asc"
     *          )
     *      ),
     *      security={ {"sanctum": {}} }
     * )
     */
    public function index(Request $request)
    {
        try {
            return TeamResource::collection($this->teamService->getTeams($request));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created team in storage.
     *
     * @OA\Post(
     *      path="/teams",
     *      summary="Create new team",
     *      tags={"Teams"},
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(ref="#/components/schemas/TeamCreate")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/Team")
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      ),
     *      security={ {"sanctum": {}} }
     * )
     */
    public function store(StoreTeamRequest $request)
    {
        try {
            return $this->teamService->createTeam($request, auth()->user()->id);
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified team.
     *
     * @OA\Get(
     *      path="/teams/{teamId}",
     *      summary="Get team by id",
     *      tags={"Teams"},
     *
     *      @OA\Parameter(
     *          name="teamId",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/Team")
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      ),
     *      security={ {"sanctum": {}} }
     * )
     */
    public function show(int $teamId)
    {
        try {
            $team = $this->teamService->getTeam($teamId);

            if (! $team) {
                return response()->json(['message' => 'Team not found'], Response::HTTP_NOT_FOUND);
            }

            return $team;

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/teams/{teamId}",
     *      summary="Update team",
     *      tags={"Teams"},
     *
     *      @OA\Parameter(
     *          name="teamId",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(ref="#/components/schemas/TeamCreate")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/Team")
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      ),
     *      security={ {"sanctum": {}} }
     * )
     */
    public function update(UpdateTeamRequest $request, int $teamId)
    {
        try {

            $team = $this->teamService->getTeam($teamId);

            if (! $team) {
                return response()->json(['message' => 'Team not found'], Response::HTTP_NOT_FOUND);
            }

            return $this->teamService->updateTeam($request, $teamId);

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/teams/{teamId}",
     *      summary="Delete team",
     *      tags={"Teams"},
     *
     *      @OA\Parameter(
     *          name="teamId",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *
     *          @OA\JsonContent()
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      ),
     *      security={ {"sanctum": {}} }
     * )
     */
    public function destroy(int $teamId)
    {
        try {

            $team = $this->teamService->getTeam($teamId);

            if (! $team) {
                return response()->json(['message' => 'Team not found'], Response::HTTP_NOT_FOUND);
            }

            $team = $this->teamService->deleteTeam($teamId);

            return response()->json($team, Response::HTTP_NO_CONTENT);
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
