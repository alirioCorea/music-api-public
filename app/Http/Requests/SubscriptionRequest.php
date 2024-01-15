<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'renewal_date' => 'required|date',
            'payment_method' => ['required', Rule::in(['credit_card', 'paypal'])],
            'payment_date' => 'required|date',
            'total' => 'required|numeric',
        ];
        
        // Si el método de pago es credit_card, se deben validar los campos de la tarjeta de crédito
        // Si el método de pago es paypal, se debe validar el campo paypal_username
        
        if ($this->input('payment_method') === 'credit_card') {
            $rules = array_merge($rules, [
                'card_number' => 'required|string',
                'expiry_month' => 'required|string',
                'expiry_year' => 'required|string',
                'security_code' => 'required|string',
            ]);
        } elseif ($this->input('payment_method') === 'paypal') {
            $rules = array_merge($rules, [
                'paypal_username' => 'required|string',
            ]);
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'user_id.required' => 'El campo user_id es requerido',
            'user_id.exists' => 'El campo user_id debe existir en la tabla users',
            'renewal_date.required' => 'El campo renewal_date es requerido',
            'renewal_date.date' => 'El campo renewal_date debe ser una fecha',
            'payment_method.required' => 'El campo payment_method es requerido',
            'payment_method.in' => 'El campo payment_method debe ser credit_card o paypal',
            'payment_date.required' => 'El campo payment_date es requerido',
            'payment_date.date' => 'El campo payment_date debe ser una fecha',
            'total.required' => 'El campo total es requerido',
            'total.numeric' => 'El campo total debe ser un número',
            'card_number.required' => 'El campo card_number es requerido',
            'card_number.string' => 'El campo card_number debe ser un string',
            'expiry_month.required' => 'El campo expiry_month es requerido',
            'expiry_month.string' => 'El campo expiry_month debe ser un string',
            'expiry_year.required' => 'El campo expiry_year es requerido',
            'expiry_year.string' => 'El campo expiry_year debe ser un string',
            'security_code.required' => 'El campo security_code es requerido',
            'security_code.string' => 'El campo security_code debe ser un string',
            'paypal_username.required' => 'El campo paypal_username es requerido',
            'paypal_username.string' => 'El campo paypal_username debe ser un string',
        ];
    }
}
