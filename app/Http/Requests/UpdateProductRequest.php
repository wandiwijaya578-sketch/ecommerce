<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ❗ WAJIB
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'weight'      => 'required|integer|min:0',

            // CHECKBOX
            'is_active'   => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',

            // IMAGES
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png|max:2048',

            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'integer|exists:product_images,id',

            'primary_image'   => 'nullable|integer|exists:product_images,id',
        ];
    }
}
