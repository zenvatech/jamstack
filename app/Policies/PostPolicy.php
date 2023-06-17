<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool|Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Post $post): bool|Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool|Response
    {
        if ($user->email !== 'admin@jamstack.com')
            return Response::deny('Only admins are authorixed to access create posts');

        Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool|Response
    {
        if ($user->isNot($post->author))
            return Response::deny('Only Post Author can update post');

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool|Response
    {
        if ($user->isNot($post->author))
            return Response::deny('Only Post Author can Delete post');

        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool|Response
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool|Response
    {
        //
    }
}
