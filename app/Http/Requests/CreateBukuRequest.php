<?php

namespace App\Http\Requests;


class CreateBukuRequest extends CustomFormRequest
{




    public function rules(): array
    {
        return [
            "judul" => "required|string",
            "penulis" => "required|string",
            "penerbit" => "required|string",
            "tahun_terbit" => "required|integer",
            "is_premium" => "required|integer",
            "cover" => "required|image|mimes:jpeg,png,jpg|max:10000",
            "ebook" => 'required|file|mimes:pdf,epub,mobi|max:665600'
        ];
    }
}
