<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="AddStudentToTeamRequest",
 *          type="object",
 *          required={"student_id"},
 *
 *          @OA\Property(property="student_id", type="integer", format="int64", example=1),
 *      )
 */
class AddStudentToTeamRequest
{
    //
}
