<?php

namespace App\Services\Auth\Auth;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $user = app('UpdateUserService')->execute([
            'user_id' => Auth::id(),
            'password' => $dto['new_password'],
            'version' => $dto['version'],
        ], true)['data'];

        $data = [
            'user' => [
                'uuid' => $user->uuid,
                'email' => $user->email,
            ],
        ];

        $this->results['data'] = $data;
        $this->results['message'] = __('success.auth.auth.password_changed');
    }

    public function prepare($dto)
    {
        if(Hash::check($dto['old_password'], Auth::user()->password) === false)
            throw new \Exception(__('error.auth.auth.invalid_old_password'), 401);

        if($dto['old_password'] === $dto['new_password'])
            throw new \Exception(__('error.auth.auth.new_password_same_as_old'), 400);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],

            'version' => ['required', 'integer'],
        ];
    }
}
