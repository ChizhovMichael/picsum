<?php

namespace App\Contracts;

use App\Dto\Response\PhotoIntegrationResponse;

interface PhotoIntegrationContract
{
    /**
     * @param int $page
     * @param int $limit
     * @return PhotoIntegrationResponse
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getPhotoList(int $page, int $limit): PhotoIntegrationResponse;
}
