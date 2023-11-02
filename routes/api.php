<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    return response()->json('Welcome to Kunaverso API');
});

Route::get(
    '/user/email/verify/{id}/{hash}/{token}/{doc}',
    [VerifyEmailController::class, '__invoke']
)->name('verification.verify');

Route::middleware([EnsureTokenIsValid::class, 'auth:sanctum', 'verified'])->group(
    function () {
        Route::get(
            '/user',
            function (Request $request) {
                return new UserResource($request->user());
            }
        );

        Route::get(
            '/user/profiles',
            [ProfileController::class, 'profiles']
        );

        Route::get(
            '/user/profiles/{id}',
            [ProfileController::class, 'profile']
        );

        Route::post(
            '/user/profiles/create',
            [ProfileController::class, 'create']
        );

        Route::post(
            '/user/profiles/{id}/update',
            [ProfileController::class, 'update']
        );

        Route::post(
            '/user/profiles/{id}',
            [ProfileController::class, 'delete']
        );

        Route::post(
            '/user/profiles/{id}/photo',
            [ProfileController::class, 'uploadPhoto']
        );

        Route::post(
            '/user/profiles/{id}/remove-photo',
            [ProfileController::class, 'deletePhoto']
        );

        Route::post(
            '/user/profile-photo',
            [UserPhotoController::class, 'update']
        );

        Route::post(
            '/user/remove-photo',
            [UserPhotoController::class, 'delete']
        );

        Route::post(
            '/user/profile-information',
            [ProfileInformationController::class, 'update']
        )
            ->name('user-profile-information.update');
    }
);

require_once 'routes.php';
