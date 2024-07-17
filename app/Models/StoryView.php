<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryView extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'user_id',
        'view_count',
        'last_viewed'
    ];
    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id');
    }
}
