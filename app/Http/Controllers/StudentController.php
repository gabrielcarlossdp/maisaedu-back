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

class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService) {}

    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
