<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class RegisteredUserController extends Controller
{
    /**
     * * @OA\Post(
     *      path="/register",
     *      operationId="register",
     *      tags={"Kunaverso"},
     *      summary="Create a new registered user.",
     *      description="Create a new registered user.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRegisterRequest"),
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UserRegisterRequest")
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User registered",
     *          @OA\JsonContent(ref="#/components/schemas/RegisterResponse")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="User register errors.",
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
     *      title="User Register request",
     *      schema="UserRegisterRequest",
     *      description="User Register request body data",
     *      required={"name","username","email","password","password_confirmation"},
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
     *          description="Password",
     * 		    property="password",
     * 		    type="string",
     * 	    ),
     *      @OA\Property(
     *          description="Password confirmation",
     * 		    property="password_confirmation",
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
    public function store(
        Request $request,
        CreatesNewUsers $creator
    ): RegisterResponse {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        event(new Registered($creator->create($request->all())));

        return app(RegisterResponse::class);
    }
}
