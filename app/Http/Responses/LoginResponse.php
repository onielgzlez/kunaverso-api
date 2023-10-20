<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
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
 *          example="2|UnyioeN35SPAbrByMflSiVr0ueCY74rCPBSIwr9y21108821"
 * 	    )
 * )
 */
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
            $user = User::where('username', $request->username)
                ->orWhere('email', $request->username)
                ->orWhere('phone', $request->username)->first();

            return response()->json([
                'message' => 'You are successfully logged in.',
                'token' => $user->createToken($request->username)->plainTextToken,
            ]);
        }

        return parent::toResponse($request);
    }
}
