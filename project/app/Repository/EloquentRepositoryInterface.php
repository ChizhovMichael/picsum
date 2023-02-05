<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @param array $expression
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function findByColumns(
        array $expression = [],
        array $columns = ['*'],
        array $relations = []
    ): ?Model;

    /**
     * @param array $payload
     * @return Model|null
     */
    public function create(array $payload): ?Model;
}
