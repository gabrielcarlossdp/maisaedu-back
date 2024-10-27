<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="Team",
 *          type="object",
 *          required={"id", "name", "description", "creator_id"},
 *
 *          @OA\Property(property="id", type="integer", format="int64", example=1),
 *          @OA\Property(property="name", type="string", example="Team name"),
 *          @OA\Property(property="description", type="string",  example="Team description"),
 *          @OA\Property(property="creator_id", type="integer", example=1),
 *      )
 */
class Team
{
    //
}
