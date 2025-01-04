<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric|between:0,99999999.99',
            'type' => 'required|string',
            'tags' => 'array|exists:tags,id',
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image.required' => 'An image is required for this product.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'The image size must not exceed 2 MB.',
        ];
    }
}
