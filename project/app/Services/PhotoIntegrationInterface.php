<?php

namespace App\Services;

use App\Dto\Response\PhotoIntegrationResponse;

interface PhotoIntegrationInterface
{
    /**
     * @param int $page
     * @param int $limit
     * @return PhotoIntegrationResponse
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getPhotoList(int $page, int $limit): PhotoIntegrationResponse;
}
