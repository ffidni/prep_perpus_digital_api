<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriBukuRequest extends CustomFormRequest
{



    public function rules(): array
    {
        return [
            "nama_kategori" => "required|string",
            "cover" => "image|mimes:jpeg,png,jpg|max:10000"
        ];
    }
}
