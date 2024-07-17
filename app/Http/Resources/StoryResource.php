<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChapterResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\UserResource;
use App\Http\Controllers\StoryController;

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
            'summary' => $this->summary,
            'is_completed' => $this->is_complete,
            'author' => $this->author,
            'total_view' => $this->story_views_count,
            'total_comment' => $this->totalComment(),
            'view_users' => UserResource::collection($this->whenLoaded('usersView')),
            'favourited_users' => UserResource::collection($this->whenLoaded('favouritedByUsers')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'chapters_count' => $this->chapters_count,
            'active' => $this->active,
            'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),
            'license_image' => $this->licenseImagePaths(),
            'cover_image' => $this->coverImagePaths(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
