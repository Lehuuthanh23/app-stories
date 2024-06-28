<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $primaryKey = 'story_id';

    protected $fillable = [
        'title',
        'author_id',
        'summary',
        'active',
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'story_id', 'story_id');
    }
}
