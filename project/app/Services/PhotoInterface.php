<?php

namespace App\Services;

use App\Dto\Response\PhotoResponse;
use Illuminate\Database\Eloquent\Collection;

interface PhotoInterface
{
    /**
     * @return PhotoResponse
     */
    public function getCurrentPhotos();

    /**
     * @param int $id
     * @param bool $status
     */
    public function updateStatusPhoto(int $id, bool $status);

    /**
     * @return Collection
     */
    public function getAllPhotos();
}
