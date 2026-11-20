<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'please enter your name',
            'email.required' => 'please enter your email address',
            'email.unique' => 'this email address is already in use',
            'password.required' => 'please enter a password',
            'password.confirmed' => 'the passwords do not match',
        ];
    }
}
