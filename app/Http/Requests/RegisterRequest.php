<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
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
                'username' => 'required|string|min:3|max:25',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
        ];
    }

     /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Please enter your username.',
            'username.min' => 'The username must be at least 3 characters.',
            'username.max' => 'The username may not be greater than 25 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }
}