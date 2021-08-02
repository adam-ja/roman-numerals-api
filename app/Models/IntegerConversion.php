<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $integer_value
 * @property string $converted_value
 * @property int $conversion_count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class IntegerConversion extends Model
{
    use HasFactory;
    use HasTimestamps;

    public $incrementing = false;

    protected $primaryKey = 'integer_value';

    protected $attributes = [
        'conversion_count' => 1,
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
