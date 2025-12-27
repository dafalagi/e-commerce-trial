<?php

namespace App\Http\Requests\API\Admin\Auth\Role;

use App\Helpers\FormRequestApi;
use App\Models\Auth\Role;
use App\Rules\ExistsUuid;

class GetRoleRequest extends FormRequestApi
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Role::class);
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'role_uuid' => $this->role_uuid,
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
            'role_uuid' => ['nullable', 'uuid', new ExistsUuid(new Role)],
        ];
    }
}
