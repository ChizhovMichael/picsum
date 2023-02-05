<?php

namespace App\Contracts;

use App\Dto\Response\PhotoResponse;

interface PhotoContract
{
    /**
     * @return PhotoResponse
     */
    public function getCurrentPhotos();
}
