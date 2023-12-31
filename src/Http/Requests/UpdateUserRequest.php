<?php

namespace Lcloss\SimplePermission\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('users_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255|unique:users,name,' . $this->user->id . ',id',
            'email'     => 'required|email|max:255|unique:users,email,' . $this->user->id . ',id',
            'password'  => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password|nullable|string|min:8',
            'roles'     => 'nullable|array',
            'roles.*'   => 'nullable|integer|exists:roles,id',
        ];
    }
}
