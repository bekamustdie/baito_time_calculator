<?php

namespace App\Http\Requests\Auth;

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
            'email' => ['required', 'string', 'email','unique:users,email'],
            "name"=>['sometimes', 'string', "min:2"],
            "surname"=> ['sometimes','string', "min:2"],
            "username"=>['required', 'string', "min:2",'unique:users,username'],
            'password' => ['required', 'string', "min:6", "confirmed"]
        ];
    }

    public function messages(){
        return [
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be string format.',
            'email.unique' => 'Email is already taken.',
            'name.string' => 'Name must be string format.',
            'name.required' => 'Name must be string format.',
            'name.min' => 'Name must be at least :min chars.',
            'password.min' => 'Password must be at least :min chars.'
            
        ];
    }
}
