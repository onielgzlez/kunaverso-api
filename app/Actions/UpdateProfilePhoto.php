<?php

namespace App\Actions;

use Illuminate\Support\Facades\Validator;
use App\Contracts\UpdatesProfilePhoto;
use App\Models\Profile;

class UpdateProfilePhoto implements UpdatesProfilePhoto
{
    /**
     * Validate and update the given profile's photo.
     *
     * @param  \App\Models\Profile $profile
     * @param  array<string, string>  $input
     */
    public function update(Profile $profile, array $input): void
    {
        Validator::make($input, [
            'photo' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validate();

        if ($input['photo']) {
            $profile->updatePhoto($input['photo']);
        }
    }
}
