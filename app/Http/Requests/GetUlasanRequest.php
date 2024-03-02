<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUlasanRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "rating" => "nullable|integer|between:1,5",
        ];
    }
}
