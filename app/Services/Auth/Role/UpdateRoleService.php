<?php

namespace App\Services\Auth\Role;

use App\Models\Auth\Role;
use App\Rules\EnvsEligibility;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class UpdateRoleService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Role::find($dto['role_id']);

        $model->name = $dto['name'] ?? $model->name;
        $model->code = $dto['code'] ?? $model->code;
        $model->description = $dto['description'] ?? $model->description;
        $model->envs_eligibility = $dto['envs_eligibility'] ?? $model->envs_eligibility;

        $this->validateVersion($model, $dto['version']);
        $this->prepareAuditUpdate($model);

        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.auth.role.updated');
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

            'name' => ['nullable', 'string', new UniqueData('auth_roles', 'name', $dto['role_id'] ?? $dto['role_uuid'])],
            'code' => ['nullable', 'string', new UniqueData('auth_roles', 'code', $dto['role_id'] ?? $dto['role_uuid'])],
            'description' => ['nullable', 'string'],
            'envs_eligibility' => ['nullable', 'string', new EnvsEligibility],

            'version' => ['required', 'integer'],
        ];
    }
}
