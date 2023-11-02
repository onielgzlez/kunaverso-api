<?php

namespace App\Http\Responses;

use App\Models\User;
use Carbon\Carbon;
use Laravel\Fortify\Http\Responses\LoginResponse as FortifyLoginResponse;

/**
 * @OA\Schema(
 *      title="User Login response",
 *      description="User Login response",
 *      @OA\Property(
 *          description="Success message",
 * 		    property="message",
 * 		    type="string",
 *          example="You are successfully logged in."
 * 	    ),
 *      @OA\Property(
 *          description="User token",
 * 		    property="token",
 * 		    type="string",
 *          example="ID|token"
 * 	    )
 * )
 */
class LoginResponse extends FortifyLoginResponse
{
    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            $user = User::where('username', $request->username)
                ->orWhere('email', $request->username)
                ->orWhere('phone', $request->username)->first();

            return response()->json([
                'message' => 'You are successfully logged in.',
                'token' => $user->createToken(
                    $request->username,
                    ['*'],
                    Carbon::now()->addDays(config('auth.login.expire', 7))
                )->plainTextToken,
            ]);
        }

        return parent::toResponse($request);
    }
}
