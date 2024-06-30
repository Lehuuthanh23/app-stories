<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name',
        'description',
        'story_id'
    ];

    // Thiết lập các mối quan hệ (relationships) nếu cần
    public function stories()
    {
        return $this->belongsToMany(Story::class, 'category_story', 'category_id', 'story_id');
    }
}
