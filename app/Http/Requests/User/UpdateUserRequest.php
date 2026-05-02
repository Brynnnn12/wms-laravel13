<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:60'],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => ['nullable', 'confirmed', Password::defaults()],

            'is_active' => ['required', 'boolean'],

            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],
        ];
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

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
