<?php

namespace App\Actions;

use App\Contracts\DeleteProfilePhoto as ContractsDeleteProfilePhoto;
use App\Models\Profile;

class DeleteProfilePhoto implements ContractsDeleteProfilePhoto
{
    /**
     * Delete the given profile's photo.
     *
     * @param  \App\Models\Profile  $profile
     */
    public function delete(Profile $profile): void
    {
        $profile->deletePhoto();
    }
}
