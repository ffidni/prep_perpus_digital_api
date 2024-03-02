<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePeminjamanRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "buku_id" => "required|integer",
            "tanggal_peminjaman" => "date",
            "tanggal_pengembalian" => "required|date",
        ];
    }
}
