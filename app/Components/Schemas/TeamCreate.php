<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="TeamCreate",
 *          type="object",
 *          required={ "name", "description"},
 *
 *          @OA\Property(property="name", type="string", example="Team name"),
 *          @OA\Property(property="description", type="string",  example="Team description"),
 *      )
 */
class TeamCreate
{
    //
}
