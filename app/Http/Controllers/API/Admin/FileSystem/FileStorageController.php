<?php

namespace App\Http\Controllers\API\Admin\FileSystem;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\FileSystem\FileStorage\StoreFileStorageRequest;

class FileStorageController extends Controller
{
    public function store(StoreFileStorageRequest $request)
    {
        $request->merge([
            'location' => ($request->category ?? 'file') . '/'. now()->format('Y-m-d'),
            'filesystem' => $request->filesystem ?? 'public',
            'compress' => in_array($request->file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png']),
        ]);

        $result = app('StoreFileStorageService')->execute($request->all());

        return response()->json([
            'success' => isset($result['error']) ? false : true,
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['response_code']);
    }
}
