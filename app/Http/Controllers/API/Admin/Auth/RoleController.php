<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Auth\Role\GetRoleRequest;
use App\Http\Requests\API\Admin\Auth\Role\DeleteRoleRequest;
use App\Http\Requests\API\Admin\Auth\Role\StoreRoleRequest;
use App\Http\Requests\API\Admin\Auth\Role\UpdateRoleRequest;
use App\Http\Resources\API\Admin\Auth\Role\GetRoleResource;

class RoleController extends Controller
{
    public function get(GetRoleRequest $request)
    {
        $results = app('GetRoleService')->execute($request->all());

        $data = isset($results['data']->id) ? new GetRoleResource($results['data']) : 
            GetRoleResource::collection($results['data']);

        return response()->json([
            'success' => isset($results['error']) ? false : true,
            'message' => $results['message'],
            'data' => $data,
            'pagination' => $results['pagination'] ?? null,
        ], $results['response_code']);
    }

    public function store(StoreRoleRequest $request)
    {
        $results = app('StoreRoleService')->execute($request->all());

        return response()->json([
            'success' => isset($results['error']) ? false : true,
            'message' => $results['message'],
            'data' => $results['data'],
        ], $results['response_code']);
    }

    public function update(UpdateRoleRequest $request)
    {
        $results = app('UpdateRoleService')->execute($request->all());

        return response()->json([
            'success' => isset($results['error']) ? false : true,
            'message' => $results['message'],
            'data' => $results['data'],
        ], $results['response_code']);
    }

    public function delete(DeleteRoleRequest $request)
    {
        $results = app('RemoveRoleService')->execute($request->all());

        return response()->json([
            'success' => isset($results['error']) ? false : true,
            'message' => $results['message'],
            'data' => $results['data'],
        ], $results['response_code']);
    }
}
