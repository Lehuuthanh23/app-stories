<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $primaryKey = 'chapter_id';

    protected $fillable = [
        'story_id',
        'title',
        'content',
        'chapter_number',
    ];

    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id', 'story_id');
    }

    public function chapterImages()
    {
        return $this->hasMany(Image::class, 'chapter_id', 'chapter_id')->chapterImages();
    }

    public function chapterImagesPaths()
    {
        return $this->chapterImages()->pluck('path')->toArray();;
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'chapter_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'chapter_id', 'chapter_id');
    }
}
