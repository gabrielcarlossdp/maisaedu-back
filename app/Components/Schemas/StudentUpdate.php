<?php

namespace App\Components\Schemas;

use Swagger\Annotations as SWG;

/**
*      @OA\Schema(
*          schema="StudentUpdate",          
*          type="object",       
*          required={ "name", "email"},          
*          @OA\Property(property="name", type="string", example="John Doe"),
*          @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"), 
*      )
*/
class StudentUpdate
{
    //
}