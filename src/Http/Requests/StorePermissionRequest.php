<?php

namespace Lcloss\SimplePermission\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('permissions_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255|unique:permissions,name',
            'actions'   => 'nullable|array',
            'actions.*' => 'nullable|string|max:255',
            'roles'    => 'nullable|array',
            'roles.*'  => 'nullable|integer|exists:roles,id',
        ];
    }
}
