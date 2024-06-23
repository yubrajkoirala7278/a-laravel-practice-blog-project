<?php

namespace Modules\Blogs\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'image', 'is_published','user_id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
{
    return $this->belongsTo(User::class);
}


    protected static function newFactory()
    {
        return \Modules\Blogs\Database\factories\BlogFactory::new();
    }
}
