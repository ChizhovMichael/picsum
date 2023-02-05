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
    public function getPhotosByPage(int $page): Collection
    {
        return DB::table($this->getTableName())
            ->select('photo_id')
            ->where([
                ['id', '>=', $page * PhotoEnum::COUNT_PHOTO_PER_PAGE + 1],
                ['id', '<=', $page * PhotoEnum::COUNT_PHOTO_PER_PAGE + PhotoEnum::COUNT_PHOTO_PER_PAGE],
            ])
            ->get();
    }
}
