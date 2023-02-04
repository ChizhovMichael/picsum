<?php

namespace App\Services;

use App\Contracts\PhotoIntegrationContract;
use App\Enum\PhotoIntegrationEnum;

class PhotoIntegrationService implements PhotoIntegrationContract
{
    private $apiUrl;

    protected $httpClient;

    /**
     * @param string $apiUrl
     * @param $httpClient
     */
    public function __construct(string $apiUrl, $httpClient)
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function getPhotoList(int $page, int $limit)
    {
        return $this->httpClient::get($this->apiUrl . PhotoIntegrationEnum::GET_PHOTO_LIST, [
            'page' => $page,
            'limit' => $limit
        ])->throw()->json();
    }
}
