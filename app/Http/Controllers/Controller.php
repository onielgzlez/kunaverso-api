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
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
