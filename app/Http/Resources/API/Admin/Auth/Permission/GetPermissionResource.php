<?php

namespace App\Http\Resources\API\Admin\Auth\Permission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'module_key' => $this->module_key,
            'module_name' => $this->module_name,
            'permission_name' => $this->permission_name,
        ];
    }
}
