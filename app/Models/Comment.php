<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment_body', 'post_id', 'name', 'email', 'is_approved'];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
