<?php

namespace App\Services\Auth\Role;

use App\Models\Auth\Role;
use App\Rules\EnvsEligibility;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreRoleService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new Role;

        $model->name = $dto['name'];
        $model->code = $dto['code'];
        $model->description = $dto['description'] ?? null;
        $model->envs_eligibility = $dto['envs_eligibility'];

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.auth.role.stored');
    }

    public function prepare($dto)
    {
        return $dto;
    }

    public function rules($dto)
    {
        return [
            'name' => ['required', 'string', new UniqueData('auth_roles', 'name')],
            'code' => ['required', 'string', new UniqueData('auth_roles', 'code')],
            'description' => ['nullable', 'string'],
            'envs_eligibility' => ['required', 'string', new EnvsEligibility],
        ];
    }
}
