<?php

namespace App\Repository\Eloquent;

use App\Models\Photo;
use App\Repository\PhotoRepositoryInterface;

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
}
