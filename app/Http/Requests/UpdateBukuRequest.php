<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "judul" => "string",
            "penulis" => "string",
            "penerbit" => "string",
            "tahun_terbit" => "integer",
            "is_premium" => "integer",
            "cover" => "image|mimes:jpeg,png,jpg|max:10000",
            "ebook" => 'file|mimes:pdf,epub,mobi|max:665600'
        ];
    }
}
