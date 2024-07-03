<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'created_at' => $this->created_at,
            'stories' => StoryResource::collection($this->whenLoaded('stories')),
            'favourite_stories' => StoryResource::collection($this->whenLoaded('favouriteStories')),
        ];
    }
}
