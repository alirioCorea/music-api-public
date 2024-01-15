<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            'publication_year' => 'required|integer|between:1900,2099',
            'genre' => 'required|string',
            'artist_id' => 'required|exists:artists,id',
            'cover_image' => 'nullable|image',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'title.required' => 'El título es requerido',
            'title.string' => 'El título debe ser un string',
            'publication_year.required' => 'El año es requerido',
            'publication_year.integer' => 'El año debe ser un número entero',
            'genre.required' => 'El género es requerido',
            'genre.string' => 'El género debe ser un string',
        ];
    }
}
