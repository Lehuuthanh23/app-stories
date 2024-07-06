<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'comment_id' => $this->comment_id,
            'chapter_id' => $this->chapter_id ?? null,
            'story_id' => $this->story_id,
            'user_id' => $this->user_id,
            'username' => $this->user ? $this->user->username : null,
            'chapter_number' => $this->chapter ? $this->chapter->chapter_number : null,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
