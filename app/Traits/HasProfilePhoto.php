<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasProfilePhoto
{
  /**
   * Get the URL to the user's profile photo.
   *
   * @return string
   */
  public function getProfilePhotoUrlAttribute()
  {
    return $this->profile_photo_path
      ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
      : $this->defaultProfilePhotoUrl();
  }

  /**
   * Get the default profile photo URL if no profile photo has been uploaded.
   *
   * @return string
   */
  protected function defaultProfilePhotoUrl()
  {
    return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
  }

  /**
   * Get the disk that profile photos should be stored on.
   *
   * @return string
   */
  protected function profilePhotoDisk()
  {
    return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
  }
}