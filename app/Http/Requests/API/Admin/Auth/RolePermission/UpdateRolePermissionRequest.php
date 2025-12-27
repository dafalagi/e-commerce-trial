<?php

namespace App\Http\Requests\API\Admin\Auth\RolePermission;

use App\Helpers\FormRequestApi;
use App\Models\Auth\RolePermission;

class UpdateRolePermissionRequest extends FormRequestApi
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', RolePermission::class);
    }

    public function prepareForValidation(): void
    {
        // 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
