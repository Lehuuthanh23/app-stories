<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'story_id',
        'chapter_id',
        'is_cover_image',
    ];
    
    /**
     * Scope a query to only include cover images.
     */
    public function scopeCoverImages($query)
    {
        return $query->where('is_cover_image', true);
    }

    public function scopeChapterImages($query)
    {
        return $query->where('is_cover_image', false);
    }

    public function getPathAttribute($value)
    {
        return Storage::url($value);
    }
    /**
     * Get the story that owns the image.
     */
    // public function story()
    // {
    //     return $this->belongsTo(Story::class, 'story_id', 'story_id');
    // }

    // /**
    //  * Get the chapter that owns the image.
    //  */
    // public function chapter()
    // {
    //     return $this->belongsTo(Chapter::class, 'chapter_id', 'chapter_id');
    // }
}
