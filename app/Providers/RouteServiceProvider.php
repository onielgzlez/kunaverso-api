<?php

namespace App\Providers;

use App\Models\AccessToken;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            $header = $request->header('KUNA-TOKEN');
            $doc = $request->input('doc');

            if ($header || $doc) {
                $token = AccessToken::where('token', $header)
                    ->orWhere('token', $doc)->first();

                if ($token && $token->limit) {
                    return Limit::perMinute($token->limit)->by($request->user()?->id ?: $request->ip());
                }
            }

            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
