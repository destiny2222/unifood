<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    public $fillable = [ 
        'title','image','description','slug', 'category_id', 'status','show_homepage'
    ];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function getSlugAttribute(){
        return Str::slug($this->title);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class);
    }
}
