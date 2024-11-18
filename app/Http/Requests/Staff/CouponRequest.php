<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => 'required|unique:coupons,code',
            'start_at' => 'required|date_format:"d/m/Y"',
            'expire_at' => 'required|date_format:"d/m/Y"',
            'customers.*' => 'nullable|exists:users,id',
            'products.*' => 'nullable|exists:products,id',
            'discount_type' => 'required|in:1,2',
            'amount' => 'required|numeric',
            'upto' => 'nullable|numeric',
            'maximum_use_limit' => 'nullable|numeric',
            'min' => 'nullable|numeric',
            'emails' => 'nullable|array',
            'emails.*' => 'required|email'
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
            'emails.*' => __('Please give a valid email address')
        ];
    }

}
