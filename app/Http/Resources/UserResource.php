<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
