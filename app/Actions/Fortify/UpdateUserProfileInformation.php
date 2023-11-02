<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * @OA\Post(
     *      path="/user/profile-information",
     *      operationId="profile-information",
     *      tags={"Kunaverso"},
     *      summary="Validate and update the given user's profile information.",
     *      description="Validate and update the given user's profile information.",
     *      security={
     *          {"sanctum": {}},
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserProfileRequest"),
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UserProfileRequest")
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User updated",
     *          @OA\JsonContent(ref="#/components/schemas/ProfileInformationUpdatedResponse")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="User profile errors.",
     *          @OA\JsonContent(
     *              @OA\Schema(type="array"),
     *              @OA\Examples(example="array",
     *                  value={"message": "Error message","errors": {"username": {"Error message"}}},
     *                  summary="An result object."
     *              ),
     *          ),
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
     *
     * @OA\Schema(
     *      title="User Profile request",
     *      schema="UserProfileRequest",
     *      description="User profile information",
     *      required={"name","username","email"},
     *      @OA\Property(
     *          description="Name",
     * 		    property="name",
     * 		    type="string",
     * 	    ),
     *      @OA\Property(
     *          description="Lastnames",
     * 		    property="lastnames",
     * 		    type="string",
     * 	    ),
     *      @OA\Property(
     *          description="Username",
     * 		    property="username",
     * 		    type="string",
     * 	    ),
     *      @OA\Property(
     *          description="Email",
     * 		    property="email",
     * 		    type="string",
     * 	    ),
     *      @OA\Property(
     *          description="Cellphone",
     * 		    property="phone",
     * 		    type="string",
     * 	    ),
     *      @OA\Property(
     *          description="About",
     * 		    property="about",
     * 		    type="string",
     * 	    ),
     *      @OA\Property(
     *          description="Birthday",
     * 		    property="birthday",
     * 		    type="date",
     * 	    ),
     * )
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'birthday' => [
                'nullable',
                'date',
                'max:30',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'lastnames' => $input['lastnames'] ?? null,
                'username' => $input['username'],
                'phone' => $input['phone'] ?? null,
                'email' => $input['email'],
                'birthday' => $input['birthday'] ?? null,
                'about' => $input['about'] ?? null,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'lastnames' => $input['lastnames'] ?? null,
            'username' => $input['username'],
            'phone' => $input['phone'] ?? null,
            'email' => $input['email'],
            'birthday' => $input['birthday'] ?? null,
            'about' => $input['about'] ?? null,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
