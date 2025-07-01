<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostCategory extends Model
{
    public $fillable = [ 
        'title','slug','status'
    ];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function getSlugAttribute(){
        return Str::slug($this->title);
    }

   public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }



}
