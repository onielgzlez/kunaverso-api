<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="Profile Resource",
 *      description="Profile Resource",
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
class ProfileResource extends JsonResource
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
            'photo_path' => $this->photo_path,
            'photo_path_url' => $this->photo_url,
        ];
    }
}
