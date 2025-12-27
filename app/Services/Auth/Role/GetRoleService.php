<?php

namespace App\Services\Auth\Role;

use App\Models\Auth\Role;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetRoleService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;
        $dto['sort_by'] = $dto['sort_by'] ?? 'updated_at';
        $dto['sort_type'] = $dto['sort_type'] ?? 'desc';

        $model = Role::orderBy($dto['sort_by'], $dto['sort_type']);

        if (isset($dto['with'])) {
            $model->with($dto['with']);
        }

        if (isset($dto['search_param']) and $dto['search_param'] != null) {
            $model->where('name','ILIKE','%'.$dto['search_param'].'%')
                ->orWhere('code','ILIKE','%'.$dto['search_param'].'%');
        }

        if (isset($dto['role_uuid']) and $dto['role_uuid'] != '') {
            $model->where('uuid', $dto['role_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }

            $data = $model->get();
        }

        $this->results['message'] = __('success.auth.role.fetched');
        $this->results['data'] = $data;
    }
}
