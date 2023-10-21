<?php

namespace App\Http\Middleware;

use App\Models\AccessToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('KUNA-TOKEN');
        $doc = $request->input('doc');
        
        abort_if(!$header && !$doc, 403, 'This action is unauthorized.');

        $token = AccessToken::where('token', $header)
            ->orWhere('token', $doc)->first();

        abort_if(!$token, 403, 'This action is unauthorized.');

        return $next($request);
    }
}
