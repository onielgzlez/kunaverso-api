<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * @OA\Schema(
 *      title="Photo Delete Response",
 *      description="Photo Delete Response",
 *      @OA\Property(
 *          description="Photo deleted",
 * 		    property="message",
 * 		    type="string",
 *          example="Photo deleted."
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
                'message' => 'Photo deleted.',
            ])
            : back()->with('status', 'Photo deleted.');
    }
}
