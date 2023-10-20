<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse as ProfileInformationUpdatedResponseContract;
use Laravel\Fortify\Fortify;

/**
 * @OA\Schema(
 *      title="User Profile information response",
 *      description="User Profile information response",
 *      @OA\Property(
 *          description="Success message",
 * 		    property="message",
 * 		    type="string",
 *          example="Profile information updated successfully."
 * 	    )
 * )
 */
class ProfileInformationUpdatedResponse implements ProfileInformationUpdatedResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->expectsJson()
            ? response()->json([
                'message' => 'Profile information updated successfully.',
            ])
            : back()->with('status', Fortify::PROFILE_INFORMATION_UPDATED);
    }
}
