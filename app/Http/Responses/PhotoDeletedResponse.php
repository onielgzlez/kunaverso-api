<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * @OA\Schema(
 *      title="User Photo Delete response",
 *      description="User Photo Delete response",
 *      @OA\Property(
 *          description="User photo deleted",
 * 		    property="message",
 * 		    type="string",
 *          example="User photo deleted."
 * 	    )
 * )
 */
class PhotoDeletedResponse implements Responsable
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
                'message' => 'User photo deleted.',
            ])
            : back()->with('status', 'User photo deleted.');
    }
}
