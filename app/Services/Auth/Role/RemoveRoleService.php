<?php

namespace App\Services\Auth\Role;

use App\Models\Auth\Role;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class RemoveRoleService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        if(count($dto['role']->rolePermissions) > 0) {
            foreach($dto['role']->rolePermissions as $rolePermission) {
                $rolePermission->delete();
            }
        }

        app('DeleteRoleService')->execute([
            'role_id' => $dto['role']->id,
            'version' => $dto['version'],
        ]);

        $this->results['data'] = [];
        $this->results['message'] = __('success.auth.role.removed');
    }

    public function prepare($dto)
    {
        $dto['role'] = Role::where('uuid', $dto['role_uuid'])->first();

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'role_uuid' => ['required', 'uuid', new ExistsUuid(new Role)],
            'version' => ['required', 'integer'],
        ];
    }
}
