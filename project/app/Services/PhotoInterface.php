<?php

namespace App\Services;

use App\Dto\Response\PhotoResponse;

interface PhotoInterface
{
    /**
     * @return PhotoResponse
     */
    public function getCurrentPhotos();
}
