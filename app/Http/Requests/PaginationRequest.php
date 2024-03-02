<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends CustomFormRequest
{

    public function rules(): array
    {
        return [
            "search" => "nullable|string",
            "per_page" => "nullable|integer",
            "page" => "nullable|integer",
        ];
    }
}
