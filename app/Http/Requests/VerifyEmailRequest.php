<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Sanctum\PersonalAccessToken;

class VerifyEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $isGranted = false;

        if ((string) $this->route('token')) {

            [$id, $token] = explode('|', $this->route('token'), 2);
            $tokenData = PersonalAccessToken::findToken($token);

            if (!$tokenData) {
                $isGranted = true;
            }

            $user = User::findOrFail((int) $this->route('id'));
           
            if (!hash_equals(sha1($user->getEmailForVerification()), (string) $this->route('hash'))) {
                $isGranted = true;
            }

            return $isGranted ? false : true;
        }

        return $isGranted;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
