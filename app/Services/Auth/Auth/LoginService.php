<?php

namespace App\Services\Auth\Auth;

use App\Models\Auth\User;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Hash;

class LoginService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $user = User::where('email', $dto['email'])->where('is_active', true)->first();
        if(!$user)
            throw new \Exception(__('error.auth.auth.invalid_credentials'), 401);

        if(Hash::check($dto['password'], $user->password) == false)
            throw new \Exception(__('error.auth.auth.invalid_credentials'), 401);

        $envs_eligibility = explode(',', $user->role->envs_eligibility);
        if(!in_array($dto['env'], $envs_eligibility))
            throw new \Exception(__('error.auth.auth.permission_denied'), 403);

        $data = [
            'user' => [
                'uuid' => $user->uuid,
                'email' => $user->email,
            ],
            'token' => $user->createToken("{$dto['env']}_token")->accessToken,
        ];

        $this->results['data'] = $data;
        $this->results['message'] = __('success.auth.auth.login');
    }

    public function rules($dto)
    {
        return [
            'email' => ['required', 'email', 'exists:auth_users'],
            'password' => ['required', 'string'],
            'env' => ['required', 'string', 'in:admin,web,mobile'],
        ];
    }
}
