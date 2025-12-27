<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Auth\Permission\GetPermissionRequest;
use App\Http\Resources\API\Admin\Auth\Permission\GetPermissionResource;

class PermissionController extends Controller
{
    public function get(GetPermissionRequest $request)
    {
        $result = app('GetPermissionService')->execute($request->all());

        $data = isset($result['data']->id) ? new GetPermissionResource($result['data']) :
            GetPermissionResource::collection($result['data']);

        return response()->json([
            'success' => isset($result['error']) ? false : true,
            'message' => $result['message'],
            'data' => $data,
            'pagination' => $result['pagination'] ?? null,
        ], $result['response_code']);
    }
}
