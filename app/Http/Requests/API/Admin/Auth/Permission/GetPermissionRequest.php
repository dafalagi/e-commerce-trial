<?php

namespace App\Http\Requests\API\Admin\Auth\Permission;

use App\Helpers\FormRequestApi;
use App\Models\Auth\Permission;
use App\Rules\ExistsUuid;

class GetPermissionRequest extends FormRequestApi
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Permission::class);
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'permission_uuid' => $this->permission_uuid,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permission_uuid' => ['nullable', 'uuid', new ExistsUuid(new Permission)],
        ];
    }
}
