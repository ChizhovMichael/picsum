<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PhotoCollection;
use App\Services\PhotoInterface;

class PhotoController extends Controller
{
    /**
     * @var PhotoInterface
     */
    protected $photoContract;

    /**
     * @param PhotoInterface $photoContract
     */
    public function __construct(PhotoInterface $photoContract)
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
