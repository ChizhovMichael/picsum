<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PhotoCollection;
use App\Services\PhotoInterface;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * @var PhotoInterface
     */
    protected $photoInterface;

    /**
     * @param PhotoInterface $photoInterface
     */
    public function __construct(PhotoInterface $photoInterface)
    {
        $this->photoInterface = $photoInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = $this->photoInterface->getCurrentPhotos();

        return response()->json([
            'data' => new PhotoCollection($response->getPhotos()),
            'next' => $response->isNextPage(),
            'page' => $response->getCurrentPage()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // 204 если нет тела
        // 200 если есть
        return response()->json([
            'id' => $id,
            'request' => json_encode($request)
        ]);
    }

}
