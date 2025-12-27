<?php

namespace App\Http\Requests\API\Admin\Auth\Role;

use App\Helpers\FormRequestApi;
use App\Models\Auth\Role;

class DeleteRoleRequest extends FormRequestApi
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('delete', Role::class);
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
            // 
        ];
    }
}
