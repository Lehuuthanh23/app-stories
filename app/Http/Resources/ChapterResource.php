<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'chapter_id' => $this->chapter_id,
            'story_id' => $this->story_id,
            'title' => $this->title,
            'content' => $this->content,
            'chapter_number' => $this->chapter_number,
            'images' => $this->chapterImages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
