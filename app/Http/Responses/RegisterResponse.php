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
            return response()->json([
                'message' => 'Registration successful, we sent you and email to verify your email address.',
            ]);
        }

        return parent::toResponse($request);
    }
}
