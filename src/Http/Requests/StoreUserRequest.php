<?php

namespace Lcloss\SimplePermission\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('users_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255|unique:users,name',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'roles'    => 'nullable|array',
            'roles.*'  => 'nullable|integer|exists:roles,id',
        ];
    }
}
