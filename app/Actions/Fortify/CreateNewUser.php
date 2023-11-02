<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:150'],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique(User::class),
            ],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique(User::class),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'birthday' => [
                'nullable',
                'date',
                'max:30',
            ],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'lastnames' => $input['lastnames'] ?? null,
            'username' => $input['username'],
            'phone' => $input['phone'] ?? null,
            'email' => $input['email'],
            'birthday' => $input['birthday'] ?? null,
            'about' => $input['about'] ?? null,
            'password' => Hash::make($input['password']),
        ]);
    }
}
