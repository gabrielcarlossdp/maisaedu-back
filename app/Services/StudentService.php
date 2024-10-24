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

    public function getStudents(Request $request): Collection|LengthAwarePaginator
    {
        return $this->cfilterSeachOrderPaginate(Student::query(), $request, [
            'name',
            'email',
            'cpf',
            'ra',
        ]);
    }

    public function createStudent(Request $request): Student
    {
        return Student::create($request->all());
    }

    public function getStudent(int $id): ?Student
    {
        return Student::find($id);
    }

    public function updateStudent(Request $request, int $id): Student
    {
        $student = Student::find($id);
        $student->update($request->all());

        return $student;
    }

    public function deleteStudent(int $id): ?Student
    {
        $student = Student::find($id);
        $student->delete();

        return $student;
    }
}
