<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * @OA\Info(title="+A Education Test Api", version="0.1")
 */
class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService) {}

    /**
     * Display a listing of the student.
     *
     * @OA\Get(
     *      path="/students",
     *      summary="Get list of students",
     *      tags={"Students"},
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
    public function index(Request $request)
    {
        try {
            return StudentResource::collection($this->studentService->getStudents($request));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created student in storage.
     *
     * @OA\Post(
     *      path="/students",
     *      summary="Create new student",
     *      tags={"Students"},
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(ref="#/components/schemas/StudentCreate")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/Student")
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
    public function store(StoreStudentRequest $request)
    {
        try {
            return $this->studentService->createStudent($request);
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified student.
     *
     * @OA\Get(
     *      path="/students/{studentId}",
     *      summary="Get student by id",
     *      tags={"Students"},
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
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/Student")
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
    public function show(int $studentId)
    {
        try {
            $student = $this->studentService->getStudent($studentId);

            if (! $student) {
                return response()->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
            }

            return $student;

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/students/{studentId}",
     *      summary="Update student",
     *      tags={"Students"},
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
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(ref="#/components/schemas/StudentUpdate")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/Student")
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
    public function update(UpdateStudentRequest $request, int $studentId)
    {
        try {

            $student = $this->studentService->getStudent($studentId);

            if (! $student) {
                return response()->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
            }

            return $this->studentService->updateStudent($request, $studentId);

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/students/{studentId}",
     *      summary="Delete student",
     *      tags={"Students"},
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
    public function destroy(int $studentId)
    {
        try {

            $student = $this->studentService->getStudent($studentId);

            if (! $student) {
                return response()->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
            }

            $student = $this->studentService->deleteStudent($studentId);

            return response()->json($student, Response::HTTP_NO_CONTENT);
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
