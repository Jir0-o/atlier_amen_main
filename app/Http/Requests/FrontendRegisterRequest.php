<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontendRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public registration
    }

    public function rules(): array
    {
        return [
            'f_name' => ['required', 'string', 'max:100'],
            'l_name' => ['required', 'string', 'max:100'],
            'email'  => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'country'=> ['nullable', 'string', 'max:191'], 
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/',
                'confirmed' 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.min'   => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter and one special character.',
            'password.confirmed' => 'Passwords do not match.',
        ];
    }
}