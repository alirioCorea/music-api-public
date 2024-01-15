<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'username' => 'required|unique:users,username',
            'birth_date' => 'required|date',
            'gender'=>'required',
            'country'=>'required',
            'postal_code'=>'required',
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
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser un email válido',
            'email.unique' => 'El email ya existe',
            'password.required' => 'La contraseña es requerida',
            'username.required' => 'El nombre de usuario es requerido',
            'username.unique' => 'El nombre de usuario ya existe',
            'birth_date.required' => 'La fecha de nacimiento es requerida',
            'birth_date.date' => 'La fecha de nacimiento debe ser una fecha válida',
            'gender.required' => 'El género es requerido',
            'country.required' => 'El país es requerido',
            'postal_code.required' => 'El código postal es requerido',
        ];
    }
}
