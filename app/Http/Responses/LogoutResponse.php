<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Http\Responses\LogoutResponse as FortifyLogoutResponse;

/**
 * @OA\Schema(
 *      title="User Logout response",
 *      description="User Logout response",
 *      @OA\Property(
 *          description="Success message",
 * 		    property="message",
 * 		    type="string",
 *          example="You are successfully logged out."
 * 	    )
 * )
 */
class LogoutResponse extends FortifyLogoutResponse
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'You are successfully logged out.',
            ]);
        }

        return parent::toResponse($request);
    }
}
