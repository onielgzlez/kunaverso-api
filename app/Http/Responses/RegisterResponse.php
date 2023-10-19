<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Http\Responses\RegisterResponse as FortifyRegisterResponse;

class RegisterResponse extends FortifyRegisterResponse
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function toResponse($request)
    {
        $this->guard->logout();
        
        if ($request->expectsJson()) {
            $user = User::where('username', $request->username)->first();

            return response()->json([
                'message' => 'Registration successful, we sent you and email to verify your email address.',
                'token' => $user->createToken($request->username)->plainTextToken,
            ]);
        }

        return parent::toResponse($request);
    }
}
