<?php

namespace App\Http\Resources;

use App\Models\IntegerConversion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntegerConversionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'integer_value'   => $this->integer_value,
            'converted_value' => $this->converted_value,
            'times_converted' => $this->conversion_count,
            'first_converted' => $this->created_at,
            'last_converted'  => $this->updated_at,
        ];
    }
}
