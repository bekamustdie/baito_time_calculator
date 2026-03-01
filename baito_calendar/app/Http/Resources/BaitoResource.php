<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaitoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "user_id"=>$this->user_id,
            "title"=>$this->title,
            "date"=>$this->date,
            "time"=>$this->time,
            "note"=>$this->note,
            "user"=>new UserResource($this->whenLoaded("user"))
        ];
    }
}
