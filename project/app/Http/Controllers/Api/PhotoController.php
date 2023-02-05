<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PhotoCollection;
use App\Http\Resources\Api\RandomPhotoCollection;
use App\Services\PhotoInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = $this->photoInterface->getCurrentPhotos();

        return response()->json([
            'data' => new RandomPhotoCollection($response->getPhotos()),
            'next' => $response->isNextPage(),
            'page' => $response->getCurrentPage(),
            'count' => $response->getCount()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        /** @var Model $update */
        $model = $this->photoInterface->updateStatusPhoto($id, $request->get('status'));

        return response()->json([
            'data' => $model
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        /** @var Model $model */
        $model = $this->photoInterface->create(
            $request->get('photo_id'),
            $request->get('status')
        );

        return response()->json([
            'data' => $model
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $response = $this->photoInterface->getAllPhotos();

        return response()->json([
            'data' => new PhotoCollection($response),
        ]);
    }

}
