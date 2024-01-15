<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaylistRequest extends FormRequest
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
            'titulo' => 'required|string',
            'user_id' => 'required|exists:users,id',
      /*       'status' => 'required|string', */
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'titulo.required' => 'El campo titulo es requerido',
            'titulo.string' => 'El campo titulo debe ser un string',
            'user_id.required' => 'El campo user_id es requerido',
            'user_id.exists' => 'El campo user_id debe existir en la tabla users',
        /*  'status.required' => 'El campo status es requerido',
            'status.string' => 'El campo status debe ser un string' */
        ];
        
    }
}
