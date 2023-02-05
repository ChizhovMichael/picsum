<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface PhotoRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param int $page
     * @return Collection
     */
    public function getPhotosByPage(int $page): Collection;
}
