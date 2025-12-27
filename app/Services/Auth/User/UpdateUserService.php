<?php

namespace App\Services\Auth\User;

use App\Models\Auth\User;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Hash;

class UpdateUserService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = User::find($dto['user_id']);

        $model->email = $dto['email'] ?? $model->email;
        $model->email_verified_at = $dto['email_verified_at'] ?? $model->email_verified_at;
        $model->password = $dto['password'] ?? $model->password;

        $this->validateVersion($model, $dto['version']);
        $this->prepareAuditUpdate($model);

        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.auth.user.updated');
    }

    public function prepare($dto)
    {
        if(isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        if(isset($dto['password']) and Hash::needsRehash($dto['password']))
            $dto['password'] = Hash::make($dto['password']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['required_without:user_id', 'uuid', new ExistsUuid(new User)],

            'email' => ['required', 'email', new UniqueData('auth_users', 'email', $dto['user_id'] ?? $dto['user_uuid'])],
            'email_verified_at' => ['nullable', 'date'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            
            'version' => ['required', 'integer'],
        ];
    }
}
