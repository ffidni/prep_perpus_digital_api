<?php
namespace App\Http\Requests;

use App\Exceptions\ApiException;
use App\Library\HelperLib;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class CustomFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation($validator)
    {
        $message = HelperLib::getValidatorErrorMessages($validator);
        throw new ApiException(Response::HTTP_BAD_REQUEST, $message, $validator->errors());
    }
}
