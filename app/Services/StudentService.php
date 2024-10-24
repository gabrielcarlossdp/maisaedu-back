<?php

namespace App\Services;

use App\Models\Student;
use App\Traits\CustomQueryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentService
{
    use CustomQueryTrait;

    /**
     * Retrieves a list of students based on the request parameters.
     *
     * @param  Request  $request  The request containing filter, search, sort, and pagination parameters.
     * @return Collection|LengthAwarePaginator The filtered, searched, ordered, and paginated list of students.
     */
    public function getStudents(Request $request): Collection|LengthAwarePaginator
    {
        return $this->cfilterSeachOrderPaginate(Student::query(), $request, [
            'name',
            'email',
            'cpf',
            'ra',
        ]);
    }

    /**
     * Creates a new student from the given request parameters.
     *
     * @param  Request  $request  The request containing the student's information.
     * @return Student The newly created student.
     */
    public function createStudent(Request $request): Student
    {
        return Student::create($request->all());
    }

    /**
     * Retrieves a student by its ID.
     *
     * @param  int  $id  The student's ID.
     * @return Student|null The student with the given ID, or null if not found.
     */
    public function getStudent(int $id): ?Student
    {
        return Student::find($id);
    }

    /**
     * Updates a student by its ID.
     *
     * @param  Request  $request  The request containing the updated student's information.
     * @param  int  $id  The student's ID.
     * @return Student The updated student.
     */
    public function updateStudent(Request $request, int $id): Student
    {
        $student = Student::find($id);
        $student->update($request->all());

        return $student;
    }

    /**
     * Deletes a student by its ID.
     *
     * @param  int  $id  The student's ID.
     * @return Student|null The deleted student, or null if not found.
     */
    public function deleteStudent(int $id): ?Student
    {
        $student = Student::find($id);
        $student->delete();

        return $student;
    }
}
