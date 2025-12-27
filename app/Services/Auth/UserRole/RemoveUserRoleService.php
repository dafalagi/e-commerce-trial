<?php
namespace App\Services\Auth\UserRole;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\UserRole;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class RemoveUserRoleService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);

        UserRole::where('role_id', $dto['role_id'])->where('user_id', $dto['user_id'])->delete();

        $this->results['data'] = [];
        $this->results['message'] = __('success.auth.user_role.removed');
    }

    public function prepare ($dto) {
        if(isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        if(isset($dto['role_uuid']))
            $dto['role_id'] = $this->findIdByUuid(Role::query(), $dto['role_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['required_without:user_id', 'uuid', new ExistsUuid(new User)],

            'role_id' => ['nullable', 'integer', new ExistsId(new Role)],
            'role_uuid' => ['required_without:role_id', 'uuid', new ExistsUuid(new Role)],
        ];
    }
}
