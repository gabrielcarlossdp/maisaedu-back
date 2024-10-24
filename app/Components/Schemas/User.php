<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="User",
 *          type="object",
 *          required={"id", "name", "email"},
 *
 *          @OA\Property(property="id", type="integer", format="int64", example=1),
 *          @OA\Property(property="name", type="string", example="John Doe"),
 *          @OA\Property(property="email", type="string", example="johndoe@example.com"),
 *      )
 */
class User
{
    //
}
