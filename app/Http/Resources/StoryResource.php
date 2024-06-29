<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChapterResource;

class StoryResource extends JsonResource
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
            'story_id' => $this->story_id,
            'title' => $this->title,
            'author_id' => $this->author_id,
            'summary' => $this->summary,
            'active' => $this->active,
            'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),
            'license_image' => $this->licenseImages,
            'cover_image' => $this->coverImages,
        ];
    }
}

