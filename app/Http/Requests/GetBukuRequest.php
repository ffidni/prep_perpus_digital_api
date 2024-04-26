<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetBukuRequest extends CustomFormRequest
{

    public function rules(): array
    {
        return [
            "tahun_terbit" => "nullable|array",
            "tahun_terbit.from" => "nullable|integer",
            "tahun_terbit.to" => "nullable|integer",
            "is_premium" => "nullable|integer",
            "kategori_id" => "nullable|integer",
            "rekomendasi" => "nullable|integer|min:0|max:1"
        ];
    }
}
