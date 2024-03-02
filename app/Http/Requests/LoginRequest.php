<?php

namespace App\Http\Requests;

class LoginRequest extends CustomFormRequest
{
    public function rules()
    {
        $fieldRules = [];

        if ($this->input('username')) {
            $fieldRules['email'] = 'nullable';
        } elseif ($this->input('email')) {
            $fieldRules['username'] = 'nullable';
        } else {
            $fieldRules['username'] = 'required_without:email';
            $fieldRules['email'] = 'required_without:username';
        }

        return array_merge($fieldRules, [
            'password' => 'required|string',
        ]);
    }
}
