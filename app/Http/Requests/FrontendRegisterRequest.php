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
            'password' => ['required', 'string', 'min:8', 'confirmed'], 
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed' => 'Password & confirm password do not match.',
        ];
    }
}