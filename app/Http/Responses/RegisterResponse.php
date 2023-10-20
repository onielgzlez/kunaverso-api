<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Http\Responses\RegisterResponse as FortifyRegisterResponse;

/**
 * @OA\Schema(
 *      title="User Register response",
 *      description="User Register response",
 *      @OA\Property(
 *          description="Success message",
 * 		    property="message",
 * 		    type="string",
 *          example="Registration successful, we sent you and email to verify your email address."
 * 	    ),
 *      @OA\Property(
 *          description="User token",
 * 		    property="token",
 * 		    type="string",
 *          example="2|UnyioeN35SPAbrByMflSiVr0ueCY74rCPBSIwr9y21108821"
 * 	    )
 * )
 */
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
