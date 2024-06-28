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
}
