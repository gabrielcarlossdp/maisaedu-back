<?php

namespace App\Components\Schemas;

/**
 *      @OA\Schema(
 *          schema="TeamPaginate",
 *          type="object",
 *
 *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Team")),
 *          @OA\Property(property="meta", type="object", @OA\Property(
 *               @OA\Property(property="current_page", type="integer"),
 *               @OA\Property(property="last_page", type="integer"),
 *               @OA\Property(property="per_page", type="integer"),
 *               @OA\Property(property="total", type="integer"),
 *               @OA\Property(property="total_pages", type="integer"),
 *          )),
 *          @OA\Property(property="links", type="object", @OA\Property(
 *               @OA\Property(property="first", type="string"),
 *               @OA\Property(property="last", type="string"),
 *               @OA\Property(property="prev", type="string"),
 *               @OA\Property(property="next", type="string"),
 *          )),
 *      )
 */
class TeamPaginate
{
    //
}
