<?php

namespace App\Services;

use App\Contracts\PhotoContract;
use App\Contracts\PhotoIntegrationContract;
use App\Dto\Response\PhotoResponse;
use App\Enum\PhotoEnum;
use App\Exceptions\PhotoIntegrationException;
use App\Repository\PhotoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\RequestException;

class PhotoService implements PhotoContract
{
    /**
     * @var PhotoIntegrationContract
     */
    protected $photoIntegrationContract;

    /**
     * @var PhotoRepositoryInterface
     */
    protected $photoRepository;

    /**
     * @param PhotoIntegrationContract $photoIntegrationContract
     * @param PhotoRepositoryInterface $photoRepository
     */
    public function __construct(
        PhotoIntegrationContract $photoIntegrationContract,
        PhotoRepositoryInterface $photoRepository
    )
    {
        $this->photoIntegrationContract = $photoIntegrationContract;
        $this->photoRepository = $photoRepository;
    }

    /**
     * @param PhotoIntegrationContract $photoIntegrationContract
     */
    public function setPhotoIntegrationContract(PhotoIntegrationContract $photoIntegrationContract): void
    {
        $this->photoIntegrationContract = $photoIntegrationContract;
    }

    /**
     * @param PhotoRepositoryInterface $photoRepository
     */
    public function setPhotoRepository(PhotoRepositoryInterface $photoRepository): void
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * @param string $link
     * @return bool
     */
    private function checkNextPage(string $link): bool
    {
        if (strpos($link, 'rel="next"')) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getCurrentPhotos()
    {
        // 1. Get count photo
        $countPhoto = $this->photoRepository->count(['id'], []);
        // 2. Define current page
        $page = floor($countPhoto / PhotoEnum::COUNT_PHOTO_PER_PAGE);
        // 3. Exclude photo
        $excludePhotos = $this->photoRepository->getPhotosByPage($page)->pluck('photo_id')->toArray();
        // 4. Get photos and links
        try {
            $photoIntegrationDto = $this->photoIntegrationContract->getPhotoList($page + 1, PhotoEnum::COUNT_PHOTO_PER_PAGE);
        } catch (RequestException $e) {
            throw new PhotoIntegrationException($e->getMessage(), $e->getCode());
        }
        // 5. Check next page
        $nextPage = $this->checkNextPage($photoIntegrationDto->getLink());

        // 6. Current page
        $currentPage = $page + 1;

        $collection = new Collection();
        foreach ($photoIntegrationDto->getPhotos() as $photo) {
            if (!in_array($photo['id'], $excludePhotos)) {
                $collection->push((object)$photo);
            }
        }

        $response = new PhotoResponse();
        $response->setPhotos($collection);
        $response->setNextPage($nextPage);
        $response->setCurrentPage($currentPage);

        return $response;
    }
}
