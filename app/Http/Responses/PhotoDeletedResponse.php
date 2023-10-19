<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

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
