<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->model->getTable();
    }

    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function count(array $columns = ['*'], array $relations = []): int
    {
        return $this->model->with($relations)->get($columns)->count();
    }

    /**
     * @inheritDoc
     */
    public function findByColumns(
        array $expression = [],
        array $columns = ['*'],
        array $relations = []
    ): ?Model
    {
        return $this->model->with($relations)->select($columns)->where($expression)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $payload): ?Model
    {
        return $this->model->with([])->create($payload);
    }
}
