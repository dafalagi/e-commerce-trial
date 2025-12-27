<?php

namespace App\Http\Requests\API\Admin\FileSystem\FileStorage;

use App\Helpers\FormRequestApi;
use App\Traits\Identifier;

class StoreFileStorageRequest extends FormRequestApi
{
    use Identifier;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:20000', 'mimes:jpeg,jpg,png,pdf']
        ];
    }
}
