<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Auth\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\Admin\Auth\Auth\GetUserSessionRequest;
use App\Http\Requests\API\Admin\Auth\Auth\LoginRequest;
use App\Http\Requests\API\Admin\Auth\Auth\LogoutRequest;
use App\Http\Requests\API\Admin\Auth\Auth\ResetPasswordRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $result = app('LoginService')->execute($request->all());

        return response()->json([
            'success' => isset($result['error']) ? false : true,
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['response_code']);
    }

    public function logout(LogoutRequest $request)
    {
        $result = app('LogoutService')->execute($request->all());

        return response()->json([
            'success' => isset($result['error']) ? false : true,
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['response_code']);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $result = app('ForgotPasswordService')->execute($request->all());

        return response()->json([
            'success' => isset($result['error']) ? false : true,
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['response_code']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = app('ResetPasswordService')->execute($request->all());

        return response()->json([
            'success' => isset($result['error']) ? false : true,
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['response_code']);
    }

    public function userSession(GetUserSessionRequest $request)
    {
        $result = app('GetUserSessionService')->execute($request->all());

        return response()->json([
            'success' => isset($result['error']) ? false : true,
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['response_code']);
    }
}
