<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'user_id',
        'username',
        'password',
        'email',
        'birth_date',
        'created_at',
        'pen_name',
        'bio',
        'previous_works',
        'is_active',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;

    public function stories()
    {
        return $this->hasMany(Story::class, 'author_id');
    }

    public function chapters()
    {
        return $this->hasManyThrough(Chapter::class, Story::class, 'author_id', 'story_id');
    }
    public function favouriteStories()
    {
        return $this->belongsToMany(Story::class, 'favourite_stories', 'user_id', 'story_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}
