<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function view(User $user, Post $post)
    {
        return $user->hasPermissionTo('view posts');
    }

    // Check if user can create a post
    public function create(User $user)
    {
        return $user->hasPermissionTo('create posts');
    }

    // Check if user can update a post
    public function update(User $user, Post $post)
    {
        return $user->hasPermissionTo('edit posts');
    }

    // Check if user can delete a post
    public function delete(User $user, Post $post)
    {
        return $user->hasPermissionTo('delete posts');
    }
}
