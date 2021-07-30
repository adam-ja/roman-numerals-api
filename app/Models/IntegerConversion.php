<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class IntegerConversion extends Model
{
    use HasTimestamps;

    public $incrementing = false;

    protected $primaryKey = 'integer_value';

    protected $attributes = [
        'conversion_count' => 0,
    ];

    protected $fillable = [
        'integer_value',
        'converted_value',
        'conversion_count',
    ];

    protected $casts = [
        'integer_value'    => 'integer',
        'conversion_count' => 'integer',
    ];
}
