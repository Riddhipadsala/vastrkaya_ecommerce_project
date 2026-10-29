<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponUpdateRequest extends FormRequest
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
            'coupon_name'=> 'required',
            'code'=> [ 'required', Rule::unique('coupons', 'code')->ignore($this->route('coupon')->id), ],
            'type'=> 'required|in:percentage,fix',
            'discount'=> 'required|numeric|min:1',
            'status'=> 'required|in:0,1',
            'uses_total'=> 'required',
            'used_total'=> 'required',
            'start_date'=> 'required|before:end_date',
            'end_date'=> 'required|after:start_date'
        ];
    }
}
