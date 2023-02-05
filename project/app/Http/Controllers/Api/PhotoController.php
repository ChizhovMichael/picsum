<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PhotoContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PhotoCollection;

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
        $response = $this->photoContract->getCurrentPhotos();

        return response()->json([
            'data' => new PhotoCollection($response->getPhotos()),
            'next' => $response->isNextPage(),
            'page' => $response->getCurrentPage()
        ]);
    }
}
