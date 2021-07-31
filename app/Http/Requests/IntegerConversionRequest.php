<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntegerConversionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'integer' => 'required|integer|between:1,3999',
        ];
    }
}
