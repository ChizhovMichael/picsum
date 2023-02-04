<?php

namespace App\Contracts;

interface PhotoContract
{
    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getCurrentPhotos();
}
