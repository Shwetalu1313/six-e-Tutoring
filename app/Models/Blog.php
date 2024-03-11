<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
    public function reactions()
    {
        return $this->hasMany(BlogReaction::class);
    }
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
    public function myReaction()
    {
        return BlogReaction::where('blog_id', $this->id)->where('user_id', Auth::id())->first();
    }
    public function attachments()
    {
        return $this->hasMany(BlogAttachment::class);
    }
}
