<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // protect with route middleware instead
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'body'  => ['required','string'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }
}