<?php

namespace App\Services;

use App\Contracts\PhotoContract;
use App\Contracts\PhotoIntegrationContract;
use App\Repository\PhotoRepositoryInterface;

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
     * @inheritDoc
     */
    public function getCurrentPhotos()
    {

        // 1. Получаем последний id фото в нашей бд и фото которые
        // 2. Определяем страницу
        // 2.1 Получаем фото которые нужно исключить для данной страницы
        // 3. Получаемм список фото + 1 с интеграционного сервиса
        // 4. Определяем наличие следующей страницы
        // 4.1 Исключаем фото которые уже есть
        // 5. Отдаем на фронтенда [фото, nextPage, count]
        // 6. В случае не удачи отдаем ошибку в формате json


        return $this->photoIntegrationContract->getPhotoList(1, 100);
    }
}
