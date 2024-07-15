<?php

namespace App\Http\Requests;

use App\Models\ProductAttribute;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeRequest extends FormRequest
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
        // return [
        //     "name" => ["required", "unique:productsattributes", "max:255"],
        //     "description" => ["required", "unique:productsattributes", "max:65535"],
        // ];

        switch ($this->method()) {
            case 'POST': {
                    return [
                        "name" => ["required", "unique:productsattributes", "max:255"],
                        "description" => ["required", "unique:productsattributes", "max:65535"],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        "name" => [
                            "max:255",
                            Rule::unique(ProductAttribute::class, "name")->ignore($this->input("id"))
                        ],
                        "description" => [
                            "max:65535",
                            Rule::unique(ProductAttribute::class, "description")->ignore($this->input("id"))
                        ],
                    ];
                }
        }
    }
}
