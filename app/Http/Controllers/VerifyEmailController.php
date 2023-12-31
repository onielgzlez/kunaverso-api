<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Laravel\Fortify\Fortify;
use Laravel\Sanctum\PersonalAccessToken;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \App\Http\Requests\VerifyEmailRequest  $request
     * @return \App\Http\Responses\VerifyEmailResponse
     */
    public function __invoke(VerifyEmailRequest $request)
    {
        if ((string) $request->route('token')) {
            [$id, $token] = explode('|', $request->route('token'), 2);
            $tokenData = PersonalAccessToken::findToken($token);

            $user = User::findOrFail((int) $request->route('id'));

            if (!$tokenData || $user->hasVerifiedEmail()) {
                abort(403, 'This action is unauthorized.');
            }

            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
                $user->tokens()->where('id', $tokenData->id)->delete();

                return $request->expectsJson()
                    ? response()->json([
                        'message' => 'Verification successfull.',
                    ])
                    : redirect()->intended(Fortify::redirects('email-verification') . '?verified=1');
            }
        }

        abort(403, 'This action is unauthorized.');
    }
}
