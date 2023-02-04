<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

interface EloquentRepositoryInterface
{
    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;
}
