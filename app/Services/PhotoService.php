<?php

namespace App\Services;

use App\Dto\Response\PhotoResponse;
use App\Enum\PhotoEnum;
use App\Exceptions\PhotoException;
use App\Exceptions\PhotoIntegrationException;
use App\Repository\PhotoRepositoryInterface;
use Illuminate\Http\Client\RequestException;

class PhotoService implements PhotoInterface
{
    /**
     * @var PhotoIntegrationInterface
     */
    protected $photoIntegrationInterface;

    /**
     * @var PhotoRepositoryInterface
     */
    protected $photoRepository;

    /**
     * @param PhotoIntegrationInterface $photoIntegrationInterface
     * @param PhotoRepositoryInterface $photoRepository
     */
    public function __construct(
        PhotoIntegrationInterface $photoIntegrationInterface,
        PhotoRepositoryInterface  $photoRepository
    )
    {
        $this->photoIntegrationInterface = $photoIntegrationInterface;
        $this->photoRepository = $photoRepository;
    }

    /**
     * @param PhotoIntegrationInterface $photoIntegrationInterface
     */
    public function setPhotoIntegrationInterface(PhotoIntegrationInterface $photoIntegrationInterface): void
    {
        $this->photoIntegrationInterface = $photoIntegrationInterface;
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
     * @return array
     */
    private function getResetPhotos(): array
    {
        $photos = $this->photoRepository->allWithExpression([
            'photo_id'
        ], [
            'status' => null
        ]);

        return $photos->pluck('photo_id')->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getCurrentPhotos(?int $page)
    {
        $resetPhotos = [];
        $countPhoto = $this->photoRepository->count(['photo_id'], []);

        if ($page === null) {
            $page = floor($countPhoto / PhotoEnum::COUNT_PHOTO_PER_PAGE);
            $resetPhotos = $this->getResetPhotos();
        }
        try {
            $photoIntegrationDto = $this->photoIntegrationInterface->getPhotoList($page + 1, PhotoEnum::COUNT_PHOTO_PER_PAGE);
        } catch (RequestException $e) {
            throw new PhotoIntegrationException($e->getMessage(), $e->getCode());
        }
        $max = $photoIntegrationDto->getPhotos()->max('id');
        $min = $photoIntegrationDto->getPhotos()->min('id');
        $excludePhotos = $this->photoRepository->allWithExpression([
            'photo_id'
        ], [
            ['photo_id', '>=', $min],
            ['photo_id', '<=', $max]
        ])->pluck('photo_id')->toArray();
        $nextPage = $page;
        if ($this->checkNextPage($photoIntegrationDto->getLink())) {
            ++$nextPage;
        }

        $collection = [];
        foreach ($photoIntegrationDto->getPhotos() as $photo) {
            if (!in_array($photo['id'], $excludePhotos)) {
                $collection[] = (int)$photo['id'];
            }
        }

        if (count($resetPhotos)) {
            $collection = array_merge($collection, $resetPhotos);
        }

        $response = new PhotoResponse();
        $response->setPhotos($collection);
        $response->setNextPage($nextPage);
        $response->setCurrentPage($page);
        $response->setCount(PhotoEnum::COUNT_PHOTO_PER_PAGE);

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function updateStatusPhoto(int $id, ?bool $status)
    {
        $model = $this->photoRepository->findByColumns(['photo_id' => $id]);
        if (!$model) {
            return null;
        }
        $model->setAttribute('status', $status);
        $model->save();

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function getAllPhotos()
    {
        return $this->photoRepository->all(['photo_id', 'status', 'photo_url']);
    }

    /**
     * @inheritDoc
     */
    public function create(int $id, bool $status, string $photoUrl)
    {
        $model = $this->photoRepository->findByColumns([
            'photo_id' => $id
        ]);

        if ($model) {
            $model->setAttribute('status', $status);
            $model->save();

            return $model;
        }

        return $this->photoRepository->create([
            'photo_id' => $id,
            'status' => $status,
            'photo_url' => $photoUrl
        ]);
    }
}
