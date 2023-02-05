<?php

namespace App\Services;

use App\Dto\Response\PhotoResponse;

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
}
