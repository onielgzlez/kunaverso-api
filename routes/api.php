<?php

use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\NewPasswordController;

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
    '/user/email/verify/{id}/{hash}/{token}',
    [VerifyEmailController::class, '__invoke']
)->name('verification.verify');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

Route::middleware('auth:sanctum')->post(
    '/user/profile-photo',
    [UserPhotoController::class, 'update']
);

Route::middleware('auth:sanctum')->post(
    '/user/remove-photo',
    [UserPhotoController::class, 'delete']
);
