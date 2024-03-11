<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogReaction extends Model
{
    protected $fillable = ['user_id', 'blog_id'];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function emoji()
    {
        return $this->belongsTo(Emoji::class);
    }
}
