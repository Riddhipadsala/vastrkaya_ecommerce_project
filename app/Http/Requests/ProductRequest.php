<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'                => 'required|string|max:255',
            'brand'               => 'nullable|string|max:255',
            'description'         => 'nullable|string',
            'category_id'         => 'required|exists:categories,id',
            'price'               => 'required|numeric|min:0',
            'discount_price'      => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock'               => 'required|integer|min:0',
            'image'               => 'nullable|image|max:2048',
            'status'              => 'required|in:0,1',
            'decrease_stock'      => 'nullable|integer|min:0',
            'options'             => 'nullable|array',
            'options.*.option_id' => 'nullable|exists:options,id',
            'options.*.values'    => 'nullable|array',
            'options.*.values.*'  => 'nullable|exists:option_values,id',
        ];
    }

}
