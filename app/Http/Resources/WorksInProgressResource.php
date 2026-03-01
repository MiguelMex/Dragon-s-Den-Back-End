<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorksInProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->work_in_progress_id,
            'title'=>$this->resource->work_in_progress_title,
            'author'=>$this->resource->work_in_progress_author,
        ];
    }
}
