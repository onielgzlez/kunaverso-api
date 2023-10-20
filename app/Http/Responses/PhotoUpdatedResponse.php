<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * @OA\Schema(
 *      title="User Photo Updated response",
 *      description="User Photo Updated response",
 *      @OA\Property(
 *          description="User photo updated",
 * 		    property="message",
 * 		    type="string",
 *          example="User photo updated."
 * 	    )
 * )
 */
class PhotoUpdatedResponse implements Responsable
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
                'message' => 'User photo updated.',
            ])
            : back()->with('status', 'User photo updated.');
    }
}
