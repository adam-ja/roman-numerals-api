<?php

namespace Database\Factories;

use App\Models\IntegerConversion;
use App\Services\IntegerConverterInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

class IntegerConversionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IntegerConversion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var IntegerConverterInterface $converter */
        $converter = App::make(IntegerConverterInterface::class);
        $integer   = $this->faker->unique()->numberBetween(1, 3999);
        $createdAt = $this->faker->dateTimeBetween('-1 years', 'now');

        return [
            'integer_value'    => $integer,
            'converted_value'  => $converter->convertInteger($integer),
            'conversion_count' => $this->faker->numberBetween(1, 1000),
            'created_at'       => $createdAt,
            'updated_at'       => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
