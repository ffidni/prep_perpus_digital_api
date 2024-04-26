<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBukuReadRequest extends CustomFormRequest
{

    public function rules(): array
    {
        return [
            "buku_id" => "required|integer",
        ];
    }
}
