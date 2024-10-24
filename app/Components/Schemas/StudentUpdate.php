<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="StudentUpdate",
 *          type="object",
 *          required={ "name", "email"},
 *
 *          @OA\Property(property="name", type="string", example="John Doe"),
 *          @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *      )
 */
class StudentUpdate
{
    //
}
