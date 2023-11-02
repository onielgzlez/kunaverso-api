<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasPhoto
{
    /**
     * Upload user photo
     * @return void
     */
    public function updatePhoto(UploadedFile $photo): void
    {
        tap($this->photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'photo_path' => $photo->storePublicly('photos', [
                    'disk' => $this->photoDisk()
                ]),
            ])->save();

            if ($previous) {
                Storage::disk($this->photoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete user photo
     * @return void
     */
    public function deletePhoto(): void
    {
        if (!is_null($this->photo_path)) {
            Storage::disk($this->photoDisk())->delete($this->photo_path);
            
            $this->forceFill([
                'photo_path' => null,
            ])->save();
        }
    }

    /**
     * Getting user photo url
     * @return string
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo_path
            ? Storage::disk($this->photoDisk())->url($this->photo_path)
            : $this->defaultPhotoUrl();
    }

    /**
     * Get default photo url
     * @return string
     */
    protected function defaultPhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name);
    }

    /**
     * Get the disk that photos should be stored on
     * @return string
     */
    protected function photoDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACE_NAME'])
            ? 's3'
            : config('fortify.photo_disk', 'public');
    }
}
