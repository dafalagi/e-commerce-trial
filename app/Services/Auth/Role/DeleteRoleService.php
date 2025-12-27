<?php

namespace App\Services\Auth\Role;

use App\Models\Auth\Role;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteRoleService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Role::find($dto['role_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.auth.role.deleted');
    }

    public function prepare($dto)
    {
        if(isset($dto['role_uuid']))
            $dto['role_id'] = $this->findIdByUuid(Role::query(), $dto['role_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'role_id' => ['nullable', 'integer', new ExistsId(new Role)],
            'role_uuid' => ['required_without:role_id', 'uuid', new ExistsUuid(new Role)],

            'version' => ['required', 'integer'],
        ];
    }
}
