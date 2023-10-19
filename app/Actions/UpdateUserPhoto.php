<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Contracts\UpdatesUserPhoto;

class UpdateUserPhoto implements UpdatesUserPhoto
{
    /**
     * Validate and update the given user's photo.
     *
     * @param  \App\Models\User  $user
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'photo' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validate();

        if ($input['photo']) {
            $user->updatePhoto($input['photo']);
        }
    }
}
