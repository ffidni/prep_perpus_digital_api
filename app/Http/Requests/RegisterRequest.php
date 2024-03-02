<?php

namespace App\Http\Requests;

class RegisterRequest extends CustomFormRequest
{
    public function rules()
    {
        return [
            'nama' => 'required|string|min:2|max:50',
            'email' => 'required|email',
            'username' => 'required|string|min:6|max:20',
            'password' => 'required|string|min:6',
            'alamat' => 'required|string',
        ];
    }
}
