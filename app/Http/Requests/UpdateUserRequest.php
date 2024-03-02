<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends CustomFormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => "string",
            "nama" => "string",
            "email" => "string",
            "password" => "string",
            "alamat" => "string",
            "user_type" => "in:guest,member,librarian,admin",
            "avatar" => "image|mimes:jpeg,png,jpg|max:10000"
        ];
    }
}
