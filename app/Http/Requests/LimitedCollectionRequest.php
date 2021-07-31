<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LimitedCollectionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => 'integer|min:1',
        ];
    }
}
