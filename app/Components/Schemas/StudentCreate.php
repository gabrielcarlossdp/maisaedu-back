<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="StudentCreate",
 *          type="object",
 *          required={ "name", "email", "cpf", "ra"},
 *
 *          @OA\Property(property="name", type="string", example="John Doe"),
 *          @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *          @OA\Property(property="cpf", type="string", example="12345678901"),
 *          @OA\Property(property="ra", type="string", example="123456"),
 *      )
 */
class StudentCreate
{
    //
}
