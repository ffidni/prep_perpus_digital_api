<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => "required|string",
            "nama" => "required|string",
            "email" => "required|string",
            "password" => "required|string",
            "alamat" => "required|string",
            "user_type" => "required|in:guest,member,librarian,admin",
            "avatar" => "image|mimes:jpeg,png,jpg|max:10000"
        ];
    }
}
