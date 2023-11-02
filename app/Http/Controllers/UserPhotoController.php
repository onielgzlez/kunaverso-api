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
     * @OA\Post(
     *      path="/user/profile-photo",
     *      operationId="profile-photo",
     *      tags={"Kunaverso"},
     *      summary="Update user's photo.",
     *      description="Update user's photo.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UserPhotoRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User photo updated.",
     *          @OA\JsonContent(ref="#/components/schemas/PhotoUpdatedResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Schema(type="array"),
     *              @OA\Examples(example="array",
     *                  value={"message": "message"},
     *                  summary="An result object."
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Schema(type="array"),
     *              @OA\Examples(example="array",
     *                  value={"message": "message"},
     *                  summary="An result object."
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="User photo errors.",
     *          @OA\JsonContent(
     *              @OA\Schema(type="array"),
     *              @OA\Examples(example="array",
     *                  value={"message": "Error message","errors": {"photo": {"Error message"}}},
     *                   summary="An result object."
     *              ),
     *          )
     *      ),
     * )
     */
    public function update(UserPhotoRequest $request, UpdateUserPhoto $updater): PhotoUpdatedResponse
    {
        $updater->update($request->user(), $request->all());

        return app(PhotoUpdatedResponse::class);
    }

    /**
     * @OA\Post(
     *      path="/user/remove-photo",
     *      operationId="remove-photo",
     *      tags={"Kunaverso"},
     *      summary="Delete user's photo.",
     *      description="Delete user's photo.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="User photo deleted.",
     *          @OA\JsonContent(ref="#/components/schemas/PhotoDeletedResponse")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Schema(type="array"),
     *              @OA\Examples(example="array",
     *                  value={"message": "message"},
     *                  summary="An result object."
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Schema(type="array"),
     *              @OA\Examples(example="array",
     *                  value={"message": "message"},
     *                  summary="An result object."
     *              ),
     *          )
     *      )
     * )
     */
    public function delete(Request $request, DeleteUserPhoto $updater): PhotoDeletedResponse
    {
        $updater->delete($request->user());

        return app(PhotoDeletedResponse::class);
    }
}
