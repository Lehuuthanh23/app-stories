<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $primaryKey = 'story_id';

    protected $fillable = [
        'story_id',
        'title',
        'author_id',
        'summary',
        'active',
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'story_id', 'story_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_story', 'story_id', 'category_id');
    }


    public function coverImages()
    {
        return $this->hasMany(Image::class, 'story_id', 'story_id')->coverImages();
    }

    public function licenseImages()
    {
        return $this->hasMany(LicenseImage::class, 'story_id', 'story_id');
    }

    public function coverImagePaths()
    {
        return $this->coverImages()->pluck('path')->toArray();
    }

    public function licenseImagePaths()
    {
        return $this->licenseImages()->pluck('path')->toArray();
    }

    public function getChaptersCountAttribute()
    {
        return $this->chapters()->count();
    }

    public function favouritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourite_stories', 'story_id', 'user_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'story_id', 'story_id');
    }

    public function storyViews()
    {
        return $this->hasMany(StoryView::class, 'story_id');
    }

    // public function getTotalViewsAttribute()
    // {
    //     return $this->storyViews()->count();
    // }
}
