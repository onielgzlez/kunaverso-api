<?php

namespace Laravel\Fortify\Http\Responses;

use Laravel\Fortify\Contracts\PasswordUpdateResponse as PasswordUpdateResponseContract;
use Laravel\Fortify\Fortify;

/**
 * @OA\Schema(
 *      title="User Password response",
 *      description="User Password response",
 *      @OA\Property(
 *          description="Success message",
 * 		    property="message",
 * 		    type="string",
 *          example="Password updated successfully."
 * 	    )
 * )
 */
class PasswordUpdateResponse implements PasswordUpdateResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? response()->json([
                'message' => 'Password updated successfully.',
            ])
            : back()->with('status', Fortify::PASSWORD_UPDATED);
    }
}
