<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="User Photo request",
 *      description="User Photo request body data",
 *      required={"photo"},
 *      @OA\Property(
 *          description="image type jpg, jpeg, png",
 * 		    property="photo",
 * 		    type="string",
 *          format="binary",
 * 	    )
 * )
 */
class UserPhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['photo' => 'required|file'];
    }
}
