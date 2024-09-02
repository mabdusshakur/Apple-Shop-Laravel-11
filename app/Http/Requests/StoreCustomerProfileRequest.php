<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCustomerProfileRequest extends FormRequest
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
            'cus_name' => 'required|string|max:100',
            'cus_add' => 'required|string|max:500',
            'cus_city' => 'required|string|max:50',
            'cus_state' => 'required|string|max:50',
            'cus_postcode' => 'required|string|max:50',
            'cus_country' => 'required|string|max:50',
            'cus_phone' => 'required|string|max:50',
            'cus_fax' => 'required|string|max:50',
            'ship_name' => 'required|string|max:100',
            'ship_add' => 'required|string|max:100',
            'ship_city' => 'required|string|max:100',
            'ship_state' => 'required|string|max:100',
            'ship_postcode' => 'required|string|max:100',
            'ship_country' => 'required|string|max:100',
            'ship_phone' => 'required|string|max:50',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}