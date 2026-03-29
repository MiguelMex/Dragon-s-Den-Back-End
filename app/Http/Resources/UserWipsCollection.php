<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\WorksInProgressResource;

class UserWipsCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'nickname' => $this->nickname,
            'name' => $this->name,
            'email' => $this->email,
            'wips' => WorksInProgressResource::collection($this->whenLoaded('wips')),
        ];
    }
}
