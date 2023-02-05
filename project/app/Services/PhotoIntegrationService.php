<?php

namespace App\Services;

use App\Dto\Response\PhotoIntegrationResponse;
use App\Enum\PhotoIntegrationEnum;

class PhotoIntegrationService implements PhotoIntegrationInterface
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
    public function getPhotoList(int $page, int $limit): PhotoIntegrationResponse
    {
        $response = $this->httpClient::get($this->apiUrl . PhotoIntegrationEnum::GET_PHOTO_LIST, [
            'page' => $page,
            'limit' => $limit
        ])->throw();

        $res = new PhotoIntegrationResponse();
        $res->setLink($response->header('link'));
        $res->setPhotos(collect($response->json()));

        return $res;
    }
}
