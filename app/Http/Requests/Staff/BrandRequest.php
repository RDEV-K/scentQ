<?php

namespace App\Http\Requests\Staff;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        if ($this->method() == 'POST') {
            return [
                'name' => 'required|string|max:199',
                'slug' => 'required|string|alpha_dash|max:199|unique:brands,slug',
                'blogs' => 'nullable|array',
                'blogs.*' => 'required|array',
                'blogs.*.blog_image' => 'required',
                'blogs.*.title' => 'required|string',
                'blogs.*.desc' => 'required|string',
                'blogs.*.button_text' => 'required|string',
                'blogs.*.button_link' => 'required|string',
                'description' => 'nullable|string',
                'est_text' => 'nullable|string|max:199',
                'image' => 'nullable|string',
                'cover_image' => 'nullable|string',
                'meta' => 'nullable|array',
                'meta.add_to' => 'nullable|array',
                'meta.add_to.*' => 'required|in:' . implode(',', Product::$types)
            ];
        } else {
            return [
                'name' => 'required|string|max:199',
                'slug' => 'required|string|alpha_dash|max:199|unique:brands,slug,'. $this->brand,
                'blogs' => 'nullable|array',
                'blogs.*' => 'required|array',
                'blogs.*.blog_image' => 'required',
                'blogs.*.title' => 'required|string',
                'blogs.*.desc' => 'required|string',
                'blogs.*.button_text' => 'required|string',
                'blogs.*.button_link' => 'required|string',
                'description' => 'nullable|string',
                'est_text' => 'nullable|string|max:199',
                'image' => 'nullable|string',
                'cover_image' => 'nullable|string',
                'meta' => 'nullable|array',
                'meta.add_to' => 'nullable|array',
                'meta.add_to.*' => 'required|in:' . implode(',', Product::$types)
            ];
        }
    }
}
