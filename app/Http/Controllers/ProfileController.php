<?php

namespace App\Http\Controllers;

use App\Actions\DeleteProfilePhoto;
use App\Actions\UpdateProfilePhoto;
use App\Http\Requests\UserPhotoRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Responses\PhotoDeletedResponse;
use App\Http\Responses\PhotoUpdatedResponse;
use App\Models\Profile;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Profile response",
 *      schema="ProfileRequest",
 *      description="Profile response",
 *      @OA\Property(
 *          description="Name",
 * 		    property="name",
 * 		    type="string",
 *          example="Name"
 * 	    ),
 *      @OA\Property(
 *          description="Status default active",
 * 		    property="status",
 * 		    type="string",
 *          example="active"
 * 	    )
 * )
 */
class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *      path="/user/profiles",
     *      operationId="profiles",
     *      tags={"Kunaverso"},
     *      summary="Get user profiles.",
     *      description="Get user profiles.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="User profiles data.",
     *          @OA\JsonContent(ref="#/components/schemas/ProfileResource")
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
     * )
     */
    public function profiles(Request $request)
    {
        return ProfileResource::collection($request->user()->profiles()->get());
    }

    /**
     * @OA\Get(
     *      path="/user/profiles/{id}",
     *      operationId="profile",
     *      tags={"Kunaverso"},
     *      summary="Get data profile.",
     *      description="Get data profile.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the profile",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1.0
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Profile data.",
     *          @OA\JsonContent(ref="#/components/schemas/ProfileResource")
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
     * )
     */
    public function profile(int $id)
    {
        $profile = Profile::findOrFail($id);

        return new ProfileResource($profile);
    }

    /**
     * @OA\Post(
     *      path="/user/profiles/create",
     *      operationId="create",
     *      tags={"Kunaverso"},
     *      summary="Create profile data.",
     *      description="Create profile data.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProfileRequest"),
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/ProfileRequest")
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Update profile data.",
     *          @OA\JsonContent(ref="#/components/schemas/ProfileResource")
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
     * )
     */
    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique(Profile::class)->ignore($request->user()->id),
            ],
            'status' => [
                'nullable',
                'string',
                'max:30',
            ],
        ])->validate();

        Profile::create([
            'name' => $request->input('name'),
            'status' => $request->input('status') ?? 'active',
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            "message" => "Created successfull."
        ]);
    }

    /**
     * @OA\Post(
     *      path="/user/profiles/{id}/update",
     *      operationId="update",
     *      tags={"Kunaverso"},
     *      summary="Update profile data.",
     *      description="Update profile data.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the profile",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1.0
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProfileRequest"),
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/ProfileRequest")
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Update profile data.",
     *          @OA\JsonContent(ref="#/components/schemas/ProfileResource")
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
     * )
     */
    public function update(Request $request, int $id)
    {
        $profile = Profile::findOrFail($id);

        Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique(Profile::class)->ignore($request->user()->id),
            ],
            'status' => [
                'nullable',
                'string',
                'max:30',
            ],
        ])->validate();

        $profile->forceFill([
            'name' => $request->input('name'),
            'status' => $request->input('status') ?? 'active'
        ])->save();

        return response()->json([
            "message" => "Updated successfull."
        ]);
    }

    /**
     * @OA\Post(
     *      path="/user/profiles/{id}",
     *      operationId="delete",
     *      tags={"Kunaverso"},
     *      summary="Remove profile.",
     *      description="Remove profile.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the profile",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1.0
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Remove profile.",
     *          @OA\JsonContent(
     *              @OA\Schema(type="array"),
     *              @OA\Examples(example="array",
     *                  value={"message": "message"},
     *                  summary="An result object."
     *              ),
     *          )
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
     * )
     */
    public function delete(int $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->deleteOrFail();

        return response()->json([
            "message" => "Profile deleted successfull."
        ]);
    }

    /**
     * @OA\Post(
     *      path="/user/profiles/{id}/photo",
     *      operationId="uploadPhoto",
     *      tags={"Kunaverso"},
     *      summary="Update profile photo.",
     *      description="Update profile photo.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the profile",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1.0
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UserPhotoRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Photo updated.",
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
     *          description="Photo errors.",
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
    public function uploadPhoto(UserPhotoRequest $request, int $id, UpdateProfilePhoto $updater): PhotoUpdatedResponse
    {
        $profile = Profile::findOrFail($id);
        $updater->update($profile, $request->all());

        return app(PhotoUpdatedResponse::class);
    }

    /**
     * @OA\Post(
     *      path="/user/profiles/{id}/remove-photo",
     *      operationId="deletePhoto",
     *      tags={"Kunaverso"},
     *      summary="Delete profile photo.",
     *      description="Delete profile photo.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the profile",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1.0
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Profile photo deleted.",
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
    public function deletePhoto(int $id, DeleteProfilePhoto $updater): PhotoDeletedResponse
    {
        $profile = Profile::findOrFail($id);
        $updater->delete($profile);

        return app(PhotoDeletedResponse::class);
    }
}
