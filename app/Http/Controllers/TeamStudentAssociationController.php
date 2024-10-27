<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStudentToTeamRequest;
use App\Http\Resources\StudentResource;
use App\Services\TeamService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class TeamStudentAssociationController extends Controller
{
    public function __construct(private TeamService $teamService) {}

    /**
     * Display a listing of the student on a team.
     *
     * @OA\Get(
     *      path="/team/{teamId}/students",
     *      summary="Get list of students on a team",
     *      tags={"TeamStudentAssociations"},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(
     *               oneOf={
     *
     *                      @OA\Schema(ref="#/components/schemas/StudentPaginate"),
     *                      @OA\Schema(ref="#/components/schemas/Student")
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
    public function index(int $teamId)
    {
        try {

            $team = $this->teamService->getTeam($teamId);

            if (! $team) {
                return response()->json(['message' => 'Team not found'], Response::HTTP_NOT_FOUND);
            }

            return StudentResource::collection($this->teamService->listStudentsByTeam($teamId));

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Adds a student to a team.
     *
     * @OA\Post(
     *      path="/teams/{teamId}/students",
     *      summary="Add student to team",
     *      tags={"TeamStudentAssociations"},
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
     *          @OA\JsonContent(ref="#/components/schemas/AddStudentToTeamRequest")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
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
    public function store(AddStudentToTeamRequest $request, int $teamId)
    {
        try {

            $team = $this->teamService->getTeam($teamId);

            if (! $team) {
                return response()->json(['message' => 'Team not found'], Response::HTTP_NOT_FOUND);
            }

            return $this->teamService->addStudentToTeam($request, $teamId);

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove a student from a team.
     *
     * @OA\Delete(
     *      path="/teams/{teamId}/students/{studentId}",
     *      summary="Remove student from team",
     *      tags={"TeamStudentAssociations"},
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
     *      @OA\Parameter(
     *          name="studentId",
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
     *          description="Successful operation"
     *      ),
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
    public function destroy(int $teamId, int $studentId)
    {
        try {

            $team = $this->teamService->getTeam($teamId);

            if (! $team) {
                return response()->json(['message' => 'Team not found'], Response::HTTP_NOT_FOUND);
            }

            $association = $this->teamService->removeStudentFromTeam($studentId, $teamId);

            return response()->json($association, Response::HTTP_NO_CONTENT);

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
