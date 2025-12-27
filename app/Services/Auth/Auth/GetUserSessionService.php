<?php

namespace App\Services\Auth\Auth;

use App\Models\Auth\User;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetUserSessionService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        // if($dto['user']->isSalesperson()) {
        //     $profile = $dto['user']->salesperson;
        // }else {
        //     $profile = $dto['user']->employee;
        // }

        $permissions = $dto['user']->role->permissions->unique('module_name')->map(function($permission) use($dto) {
            $accesses = $dto['user']->role->permissions
                ->where('module_name', $permission->module_name)
                ->map(fn($access) => [$access->permission_name => true])
                ->values();

            return [
                'module_name' => $permission->module_name,
                'accesses' => $accesses,
            ];
        })->values();

        $data = [
            'user' => [
                'uuid' => $dto['user']->uuid,
                'email' => $dto['user']->email,
                'version' => $dto['user']->version,
            ],
            // 'profile' => [
            //     'uuid' => $profile->uuid,
            //     'name' => $profile->name,
            //     'phone_number' => $profile->phone_number,
            //     'version' => $profile->version,
            //     'photo' => isset($profile->photo_id) ? [
            //         'uuid' => $profile->photo->uuid,
            //         'url' => $profile->photo->url,
            //     ] : null,
            // ],
            'role' => [
                'uuid' => $dto['user']->role->uuid,
                'name' => $dto['user']->role->name,
                'code' => $dto['user']->role->code,
                'version' => $dto['user']->role->version,
            ],
            'permissions' => $permissions,
        ];

        $this->results['data'] = $data;
        $this->results['message'] = __('success.auth.auth.user_session_fetched');
    }

    public function prepare($dto)
    {
        $dto['user'] = User::where('uuid', $dto['user_uuid'])
            ->with([
                'role.permissions',
            ])
            ->first();

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'user_uuid' => ['required', 'uuid', new ExistsUuid(new User)],
        ];
    }
}
