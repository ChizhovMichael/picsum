<?php

namespace App\Dto\Response;



use Illuminate\Database\Eloquent\Collection;

class PhotoResponse
{
    /** @var Collection */
    private $photos;

    /** @var boolean */
    private $nextPage;

    /** @var integer */
    private $currentPage;

    /**
     * @return Collection
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    /**
     * @param Collection $photos
     */
    public function setPhotos(Collection $photos): void
    {
        $this->photos = $photos;
    }

    /**
     * @return bool
     */
    public function isNextPage(): bool
    {
        return $this->nextPage;
    }

    /**
     * @param bool $nextPage
     */
    public function setNextPage(bool $nextPage): void
    {
        $this->nextPage = $nextPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     */
    public function setCurrentPage(int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }
}
