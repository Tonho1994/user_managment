<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
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
            //
            'name' => ['required', 'max:40'],
            'email' => ['required', 'email', 'max:150'],
            'password' => ['nullable', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/'],
            'phone' => ['nullable', 'max:40'],
            'role' => ['required', 'exists:roles,name'],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'name.max' => 'Maximum 40 caracters',
            'email.required' => 'An email is required',
            'email.email' => 'Must be like example@domain.com',
            'email.max' => 'Maximum 150 caracters',
            'password.not_regex' => 'Incorrect Format',
            'phone.max' => 'Maximum 40 caracters',
            'role.required' => 'A role is required',
            'role.exists' => 'Invalid Role',
        ];
    }
}
