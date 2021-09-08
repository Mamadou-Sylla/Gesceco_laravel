<?php

namespace App\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource{

    public function toArray($request)
    {
        return parent::toArray($request);
    }
    
}