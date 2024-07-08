<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';

    // Khóa chính
    protected $primaryKey = 'comment_id';

    // Các thuộc tính có thể được gán giá trị hàng loạt
    protected $fillable = [
        'content',
        'user_id',
        'chapter_id',
        'story_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id');
    }
}
