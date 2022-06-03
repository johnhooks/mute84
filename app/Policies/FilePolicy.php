<?php

namespace App\Policies;

use App\Models\User;
use App\Models\File;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given post can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\File  $file
     * @return bool
     */
    public function delete(User $user, File $file)
    {
        return $user->id === $file->user_id ? Response::allow() : Response::deny('You do not own this file.');
    }
}
