<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="Student",
 *          type="object",
 *          required={"id", "name", "email", "cpf", "ra"},
 *
 *          @OA\Property(property="id", type="integer", format="int64", example=1),
 *          @OA\Property(property="name", type="string", example="John Doe"),
 *          @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *          @OA\Property(property="cpf", type="string", example="12345678901"),
 *          @OA\Property(property="ra", type="string", example="123456"),
 *      )
 */
class Student
{
    //
}
