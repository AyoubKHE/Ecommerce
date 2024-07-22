<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
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
                        "first_name" => ["required", "min:3", "max:30"],
                        "last_name" => ["required", "min:3", "max:30"],
                        "email" => ["required", "email", "unique:users", "max:255"],
                        "phone" => ["unique:users", "size:10"],
                        "password" => ["required", "min:5", "max:255", "confirmed"],
                    ];
                }
            // case 'PUT':
            // case 'PATCH': {
            //         return [
            //             "first_name" => ["nullable","min:3", "max:30"],
            //             "last_name" => ["nullable","min:3","max:30"],
            //             "username" => [
            //                 "nullable", "min:3", "max:50",
            //                 Rule::unique(User::class, "username")->ignore($this->input("id"))
            //             ],

            //             "email" => [
            //                 "nullable", "max:255",
            //                 Rule::unique(User::class, "email")->ignore($this->input("id"))
            //             ],
            //             "password" => ["nullable", "min:5", "max:255"],
            //             "phone" => [
            //                 "nullable", "min:10", "max:10",
            //                 Rule::unique(User::class, "phone")->ignore($this->input("id"))
            //             ],
            //             "birth_date" => ["date"],
            //             "user_image" => ["image", "max:5000", "mimes:jpg,png,jpeg,svg"],
            //         ];
            //     }
        }
    }
}
