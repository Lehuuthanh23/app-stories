<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LicenseImage extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'license_images';

    // Các cột có thể được gán hàng loạt
    protected $fillable = [
        'path',
        'story_id',
        'chapter_id',
    ];

    // Thiết lập các mối quan hệ (relationships)

    // Mối quan hệ với bảng stories
    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id', 'story_id');
    }

    // Mối quan hệ với bảng chapters
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'chapter_id');
    }

    public function getPathAttribute($value)
    {
        return Storage::url($value);
    }
}
