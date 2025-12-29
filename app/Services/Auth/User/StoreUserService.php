<?php

namespace App\Services\Auth\User;

use App\Models\Auth\User;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Hash;

class StoreUserService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new User;

        $model->email = $dto['email'];
        $model->email_verified_at = $dto['email_verified_at'] ?? null;
        $model->password = $dto['password'];

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.auth.user.stored');
    }

    public function prepare($dto)
    {
        if(isset($dto['password']) and Hash::needsRehash($dto['password']))
            $dto['password'] = Hash::make($dto['password']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'email' => ['required', 'email', new UniqueData('auth_users', 'email')],
            'email_verified_at' => ['nullable', 'date'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
