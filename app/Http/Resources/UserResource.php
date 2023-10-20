<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="User Resource",
 *      description="User Resource",
 *      @OA\Property(
 * 		    property="id",
 * 		    type="integer",
 *          example=1
 * 	    ),
 *      @OA\Property(
 * 		    property="name",
 * 		    type="string",
 *          example="Anonymous"
 * 	    ),
 *      @OA\Property(
 * 		    property="lastnames",
 * 		    type="string",
 *          example="Unknown Unknown"
 * 	    ),
 *      @OA\Property(
 * 		    property="username",
 * 		    type="string",
 *          example="anonymous"
 * 	    ),
 *      @OA\Property(
 * 		    property="phone",
 * 		    type="string",
 *          example="+xxxxxxxx"
 * 	    ),
 *      @OA\Property(
 * 		    property="email",
 * 		    type="string",
 *          example="anonymous@example.com"
 * 	    ),
 *      @OA\Property(
 * 		    property="created",
 * 		    type="date",
 *          example="2023-10-19 16:19:48"
 * 	    ),
 *      @OA\Property(
 * 		    property="birthday",
 * 		    type="date",
 *          example="2002-01-02"
 * 	    ),
 *      @OA\Property(
 * 		    property="about",
 * 		    type="string",
 *          example="I'am Anonymous born in January, etc."
 * 	    ),
 *      @OA\Property(
 * 		    property="photo_path",
 * 		    type="string",
 *          example="photos/32EXt5viOVQl1w6E9m11SF5YmEPc2qc6Pjewrmli.jpg"
 * 	    ),
 *      @OA\Property(
 * 		    property="photo_path_url",
 * 		    type="string",
 *          example="http://localhost/storage/photos/32EXt5viOVQl1w6E9m11SF5YmEPc2qc6Pjewrmli.jpg"
 * 	    ),
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastnames' => $this->lastnames,
            'username' => $this->username,
            'phone' => $this->phone,
            'email' => $this->email,
            'created' => $this->created_at,
            'birthday' => $this->birthday,
            'about' => $this->about,
            'photo_path' => $this->photo_path,
            'photo_path_url' => $this->photo_url,
        ];
    }
}
