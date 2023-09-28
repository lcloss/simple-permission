<?php

namespace Lcloss\SimplePermission\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('roles_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255|unique:roles,name',
            'slug'  => 'required|string|max:255|unique:roles,slug',
            'level' => 'required|integer|min:100|max:300',
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|integer|exists:permissions,id',
        ];
    }
}
