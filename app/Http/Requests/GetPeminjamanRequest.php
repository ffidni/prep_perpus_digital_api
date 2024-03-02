<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetPeminjamanRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "dipinjam" => "nullable|array",
            "dipinjam.from" => "nullable|date",
            "dipinjam.to" => "nullable|date",
            "dikembalikan" => "nullable|array",
            "dikembalikan.from" => "nullable|date",
            "dikembalikan.to" => "nullable|date",
            "status_peminjaman" => "nullable|string",
        ];
    }
}
