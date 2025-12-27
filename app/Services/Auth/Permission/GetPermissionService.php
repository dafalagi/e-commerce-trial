<?php

namespace App\Services\Auth\Permission;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetPermissionService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = Permission::query();

        if (isset($dto['with'])) {
            $model->with($dto['with']);
        }

        if (isset($dto['search_param'])) {
            $model->where('permission_name','ILIKE','%'.$dto['search_param'].'%');
        }

        if (isset($dto['permission_uuid']) and $dto['permission_uuid'] != '') {
            $model->where('uuid', $dto['permission_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }

            $data = $model->get();
        }

        $this->results['message'] = __('success.auth.permission.fetched');
        $this->results['data'] = $data;
    }
}
