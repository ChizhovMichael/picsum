<?php

namespace App\Repository\Eloquent;

use App\Enum\PhotoEnum;
use App\Models\Photo;
use App\Repository\PhotoRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PhotoRepository extends BaseRepository implements PhotoRepositoryInterface
{
    /**
     * @var Photo
     */
    protected $model;

    /**
     * @param Photo $model
     */
    public function __construct(Photo $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function getCurrentPhotos(): Collection
    {
        $page = floor(DB::table($this->getTableName())->max('id') / PhotoEnum::ITEMS);

        return DB::table($this->getTableName())
            ->select('id')
            ->where([
                ['id', '>=', $page * PhotoEnum::ITEMS],
                ['id', '<=', $page * PhotoEnum::ITEMS + (PhotoEnum::ITEMS - 1)],
            ])->get();
    }
}
