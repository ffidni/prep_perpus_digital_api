<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends CustomFormRequest
{

    public function rules(): array
    {
        return [
            "image" => "nullable|image|mimes:jpeg,png,jpg|max:10000"
        ];
    }
}
