<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PhotoContract;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    /**
     * @var PhotoContract
     */
    protected $photoContract;

    /**
     * @param PhotoContract $photoContract
     */
    public function __construct(PhotoContract $photoContract)
    {
        $this->photoContract = $photoContract;
    }


    public function index()
    {
        return $this->photoContract->getCurrentPhotos();
    }
}
