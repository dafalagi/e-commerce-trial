<?php

namespace App\Services\Auth\User;

use App\Models\Auth\User;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteUserService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = User::find($dto['user_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.auth.user.deleted');
    }

    public function prepare($dto)
    {
        if(isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['required_without:user_id', 'uuid', new ExistsUuid(new User)],

            'version' => ['required', 'integer'],
        ];
    }
}
