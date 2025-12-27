<?php

namespace App\Services\Auth\RolePermission;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\RolePermission;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class UpdateRolePermissionService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $role_permission = RolePermission::where('role_id', $dto['role_id'])
            ->where('permission_id', $dto['permission_id'])
            ->first();

        if($role_permission) {
            RolePermission::where('role_id', $dto['role_id'])
                ->where('permission_id', $dto['permission_id'])
                ->delete();
        }else {
            RolePermission::insert([
                'role_id' => $dto['role_id'],
                'permission_id' => $dto['permission_id'],
            ]);
        }
        $this->results['data'] = [];
        $this->results['message'] = __('success.auth.role_permission.updated');
    }

    public function prepare($dto)
    {
        if(isset($dto['role_uuid']))
            $dto['role_id'] = $this->findIdByUuid(Role::query(), $dto['role_uuid']);

        if(isset($dto['permission_uuid']))
            $dto['permission_id'] = $this->findIdByUuid(Permission::query(), $dto['permission_uuid'], true);

        return $dto;
    }

    public function rules($dto) {
        return [
            'role_id' => ['nullable', 'integer', new ExistsId(new Role)],
            'role_uuid' => ['required_without:role_id', 'uuid', new ExistsUuid(new Role)],

            'permission_id' => ['nullable', 'integer', new ExistsId(new Permission, no_deleted_at: true)],
            'permission_uuid' => ['required_without:permission_id', 'uuid', new ExistsUuid(new Permission, no_deleted_at: true)],
        ];
    }
}
