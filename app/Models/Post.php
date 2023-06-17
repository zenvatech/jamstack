<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Post extends Model
{
    use HasFactory, Mediable;

    protected $guarded = [
        'id'
    ];

    protected $appends = [
        'thumbnail'
    ];

    protected $with = [
        'author'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function thumbnail(): Attribute
    {
        return new Attribute(get: fn () => $this->lastMedia('thumbnail')?->getUrl());
    }
}
