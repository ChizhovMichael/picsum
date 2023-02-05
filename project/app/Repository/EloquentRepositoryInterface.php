<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

interface EloquentRepositoryInterface
{

    /**
     * @return string
     */
    public function getTableName(): string;

    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * @param array $columns
     * @param array $relations
     * @return int
     */
    public function count(array $columns = ['*'], array $relations = []): int;
}
