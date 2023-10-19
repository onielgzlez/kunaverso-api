<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Http\Responses\LoginResponse as FortifyLoginResponse;

class LoginResponse extends FortifyLoginResponse
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            $user = User::where('username', $request->username)->first();

            return response()->json([
                'message' => 'You are successfully logged in.',
                'token' => $user->createToken($request->username)->plainTextToken,
            ]);
        }

        return parent::toResponse($request);
    }
}
