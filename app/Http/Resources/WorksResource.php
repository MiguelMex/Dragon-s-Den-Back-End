<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->work_id,
            'title'=>$this->title,
            'description'=>$this->description,
            'status'=>$this->status,
            'cover'=>$this->cover,
            'author'=>$this->author,
            'age_restriction'=>$this->age_restriction,
        ];
    }
}
