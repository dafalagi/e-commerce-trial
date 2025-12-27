<?php

namespace App\Services\Auth\User;

use App\Models\Auth\Role;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class CreateUserService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $user = app('StoreUserService')->execute([
            'email' => $dto['email'],
            'password' => $dto['password'],
        ], true)['data'];

        app('AddUserRoleService')->execute([
            'user_id' => $user->id,
            'role_uuid' => $dto['role_uuid'],
        ], true);

        $this->results['data'] = $user;
        $this->results['message'] = __('success.auth.user.created');
    }

    public function prepare($dto)
    {
        return $dto;
    }

    public function rules($dto)
    {
        return [
            'email' => ['required', 'email', new UniqueData('auth_users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'role_uuid' => ['required', 'uuid', new ExistsUuid(new Role)],
        ];
    }
}
