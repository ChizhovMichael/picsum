<?php

namespace App\Contracts;

interface PhotoIntegrationContract
{
    /**
     * @param int $page
     * @param int $limit
     * @return mixed
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getPhotoList(int $page, int $limit);
}
