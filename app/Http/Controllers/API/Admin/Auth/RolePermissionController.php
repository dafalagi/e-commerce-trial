<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Auth\RolePermission\UpdateRolePermissionRequest;

class RolePermissionController extends Controller
{
    public function update(UpdateRolePermissionRequest $request)
    {
        $results = app('UpdateRolePermissionService')->execute($request->all());

        return response()->json([
            'success' => isset($results['error']) ? false : true,
            'message' => $results['message'],
            'data' => $results['data'],
        ], $results['response_code']);
    }
}
