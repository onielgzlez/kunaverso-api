<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * @OA\Schema(
 *      title="Photo Updated Response",
 *      description="Photo Updated Response",
 *      @OA\Property(
 *          description="Photo updated",
 * 		    property="message",
 * 		    type="string",
 *          example="Photo updated."
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
                'message' => 'Photo updated.',
            ])
            : back()->with('status', 'Photo updated.');
    }
}
