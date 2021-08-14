<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_published',
        'user_id',
    ];
    protected $hidden = [
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        if (Auth::check()) {
            return $this->hasMany(Comment::class)->orderBy('id','DESC');
        }
        return $this->hasMany(Comment::class)->where('is_published',true)->orderBy('id','DESC');
    }
}
