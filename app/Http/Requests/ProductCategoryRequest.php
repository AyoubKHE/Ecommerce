<?php

namespace App\Http\Requests;

use App\Models\ProductCategory;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        "name" => ["required", "unique:productscategories", "max:255"],
                        "description" => ["required", "unique:productscategories", "max:65535"],
                        "is_active" => ["required"],
                        "base_category_name" => ["required"],
                        'product_category_image' => ["required", "image", "max:5000", "mimes:jpg,png,jpeg,svg"]
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        "name" => [
                            "max:255",
                            Rule::unique(ProductCategory::class, "name")->ignore($this->input("id"))
                        ],
                        "description" => [
                            "max:65535",
                            Rule::unique(ProductCategory::class, "description")->ignore($this->input("id"))
                        ],
                        "is_active" => ["required"],
                        "base_category_name" => ["required"],
                        'product_category_image' => [
                            "image", "max:5000", "mimes:jpg,png,jpeg,svg",
                        ]
                    ];
                }
        }
    }
}
