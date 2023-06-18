<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'author',
        'category'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFilter(Builder $query)
    {
        $order = request('order', 'desc');

        $query->when(request('category') ?? false, fn (Builder $query, $category) => $query->whereRelation('category', 'slug', $category))
            ->when($order, fn (Builder $query, $order) => $query->orderBy('created_at', $order))
            ->when(
                request('q') ?? false,
                fn (Builder $query, $q) => $query
                    ->where('title', 'like', '%' . str($q)->replace(' ', '%')->toString() . '%')
                    ->orWhereRelation('category', 'name', 'like', '%' . str($q)->replace(' ', '%')->toString() . '%')
                    ->orWhere('body', 'like', '%' . str($q)->replace(' ', '%')->toString() . '%')
            );
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function thumbnail(): Attribute
    {
        return new Attribute(get: fn () => $this->lastMedia('thumbnail')?->getUrl());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
