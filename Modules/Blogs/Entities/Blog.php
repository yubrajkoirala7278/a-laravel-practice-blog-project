<?php

namespace Modules\Blogs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'image', 'is_published'];

    public function getRouteKeyName()
    {
        return 'slug';
    }


    protected static function newFactory()
    {
        return \Modules\Blogs\Database\factories\BlogFactory::new();
    }
}
