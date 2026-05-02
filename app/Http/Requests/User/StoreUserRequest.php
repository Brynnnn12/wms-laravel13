<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'is_active' => ['required', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'is_active' => 'status user',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.*.exists' => 'Role yang dipilih tidak valid.',
            'is_active.required' => 'Status user wajib dipilih.',
        ];
    }

}
