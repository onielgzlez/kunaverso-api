<?php

namespace App\Actions;

use App\Contracts\DeleteUserPhoto as ContractsDeleteUserPhoto;
use App\Models\User;

class DeleteUserPhoto implements ContractsDeleteUserPhoto
{
    /**
     * Delete the given user's photo.
     *
     * @param  \App\Models\User  $user
     */
    public function delete(User $user): void
    {
        $user->deletePhoto();
    }
}
