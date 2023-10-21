<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Kunaverso API Documentation",
 *      description="Kunaverso Api",
 *      @OA\Contact(
 *          email="oniel.gzlez@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\PathItem(path="/api")
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Kunaverso API Server"
 * )

 *
 * @OA\Tag(
 *     name="Kunaverso",
 *     description="API Endpoints of Kunaverso"
 * )
 *
 * @OA\Get(
 *      path="/user",
 *      operationId="user",
 *      tags={"Kunaverso"},
 *      summary="Get user info.",
 *      description="Get user info.",
 *      security={
 *          {"sanctum": {}},
 *      },
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
 *      )
 * )
 *
 * @OA\Post(
 *      path="/login",
 *      operationId="login",
 *      tags={"Kunaverso"},
 *      summary="Try to login an user.",
 *      description="Login user by user or email and password.",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UserLoginRequest"),
 *          @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/UserLoginRequest")
 *         )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="User logged in",
 *          @OA\JsonContent(ref="#/components/schemas/LoginResponse"),
 *          @OA\Header(
 *             header="X-Rate-Limit",
 *             @OA\Schema(
 *                 type="integer",
 *                 format="int32"
 *             ),
 *             description="calls per minutes allowed by the user"
 *         ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="User login errors.",
 *          @OA\JsonContent(
 *              @OA\Schema(type="array"),
 *              @OA\Examples(example="array",
 *                  value={"message": "Error message","errors": {"username": {"Error message"}}},
 *                  summary="An result object."
 *              ),
 *          ),
 *          @OA\Header(
 *             header="X-Rate-Limit",
 *             @OA\Schema(
 *                 type="integer",
 *                 format="int32"
 *             ),
 *             description="calls per minutes allowed by the user"
 *         ),
 *      ),
 *      @OA\Response(
 *          response=429,
 *          description="Too Many Attempts.",
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
 *
 * @OA\Post(
 *      path="/logout",
 *      operationId="logout",
 *      tags={"Kunaverso"},
 *      summary="Try to logged out an user.",
 *      description="Logged out and user.",
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(ref="#/components/schemas/LogoutResponse")
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
 * @OA\Post(
 *      path="/register",
 *      operationId="register",
 *      tags={"Kunaverso"},
 *      summary="Create a new user.",
 *      description="Create a new user.",
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
 *      title="User Login request",
 *      schema="UserLoginRequest",
 *      description="User Login request body data",
 *      required={"username","password"},
 *      @OA\Property(
 *          description="Username or email",
 * 		    property="username",
 * 		    type="string",
 * 	    ),
 *      @OA\Property(
 *          description="Password",
 * 		    property="password",
 * 		    type="string",
 * 	    )
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
 *          description="Brithday",
 * 		    property="brithday",
 * 		    type="date",
 * 	    ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
