<?php

namespace App\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class CantineResource extends JsonResource{

    public function toArray($request)
    {
        return parent::toArray($request);
    }
    
}