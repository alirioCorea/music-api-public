<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends FormRequest
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
            'title' => 'required|string',
            'duration' => 'required|integer',
            'album_id' => 'required|exists:albums,id',
            'play_count' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'title.required' => 'El titulo es requerido',
            'title.string' => 'El titulo debe ser un string',
            'duration.required' => 'La duracion es requerida',
            'duration.integer' => 'La duracion debe ser un numero',
            'album_id.required' => 'El album es requerido',
            'album_id.exists' => 'El album no existe',
            'play_count.required' => 'El play count es requerido',
            'play_count.integer' => 'El play count debe ser un numero',
        ];
    }
}
