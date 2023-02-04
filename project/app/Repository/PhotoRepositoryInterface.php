<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface PhotoRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getCurrentPhotos(): Collection;
}
