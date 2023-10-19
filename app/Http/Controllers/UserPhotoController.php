<?php

namespace App\Http\Controllers;

use App\Actions\DeleteUserPhoto;
use App\Actions\UpdateUserPhoto;
use App\Http\Requests\UserPhotoRequest;
use App\Http\Responses\PhotoDeletedResponse;
use App\Http\Responses\PhotoUpdatedResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class UserPhotoController extends Controller
{
    /**
     * Update user's photo
     */
    public function update(UserPhotoRequest $request, UpdateUserPhoto $updater): PhotoUpdatedResponse
    {
        $updater->update($request->user(), $request->all());

        return app(PhotoUpdatedResponse::class);
    }

    /**
     * Delete user's photo
     */
    public function delete(Request $request, DeleteUserPhoto $updater): PhotoDeletedResponse
    {
        $updater->delete($request->user());

        return app(PhotoDeletedResponse::class);
    }
}
