<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'title' => 'required|string|max:200',
            'short_des' => 'required|string|max:500',
            'price' => 'required|numeric',
            'is_discount' => 'required|boolean',
            'discount_price' => 'required_if:is_discount,true|numeric',
            'image' => 'nullable',
            'in_stock' => 'required|boolean',
            'stock' => 'required|integer',
            'star' => 'required|numeric',
            'remark' => 'required|in:popular,new,top,special,trending,regular',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
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