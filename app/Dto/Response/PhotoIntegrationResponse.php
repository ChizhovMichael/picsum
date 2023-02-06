<?php

namespace App\Dto\Response;

use Illuminate\Support\Collection;

class PhotoIntegrationResponse
{
    /**
     * @var Collection
     */
    private $photos;

    /**
     * @var string
     */
    private $link;

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
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }
}
