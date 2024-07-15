<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        switch ($this->method()) {
            case 'POST': {
                    return [
                        "name" => ["required", "unique:products", "max:255"],
                        "description" => ["required", "unique:products", "max:65535"],
                        "is_active" => ["required"],
                        "price" => ["max:12", "required"],
                        "brand_name" => ["required"],
                        'product_image_1' => ["required", "image", "max:5000", "mimes:jpg,png,jpeg,svg"],
                        'product_image_2' => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"],
                        'product_image_3' => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"],
                        'product_image_4' => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"]
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        "name" => [
                            "max:255",
                            Rule::unique(Product::class, "name")->ignore($this->input("id"))
                        ],
                        "description" => [
                            "max:65535",
                            Rule::unique(Product::class, "description")->ignore($this->input("id"))
                        ],
                        "is_active" => ["required"],
                        "price" => ["max:12"],
                        "brand_name" => ["required"],
                        'product_image_1' => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"],
                        'product_image_2' => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"],
                        'product_image_3' => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"],
                        'product_image_4' => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"]
                    ];
                }
        }
    }
}
