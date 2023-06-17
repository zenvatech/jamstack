<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate()->withQueryString();
        $categories = Category::orderBy('name', 'asc')->get();

        return inertia('posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $canEditPost = request()->user()?->can('update', $post);

        return inertia('posts.show', compact('post', 'canEditPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $canEditPost = request()->user()?->can('update', $post);

        return inertia('posts.edit', compact('post', 'canEditPost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $attributes = $request->safe();

        $post->update($attributes->toArray());

        return redirect()->route('blog.post.edit', $post, 303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('blog.posts', [], 303);
    }
}
