<?php

namespace Tests\Feature\Http\Controllers\Api\IntegerConversionController;

use App\Models\IntegerConversion;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class LatestTest extends FeatureTestCase
{
    private string $uri;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uri = route('api.integer-conversion.latest');
    }

    public function testReturnsTenLatestConversionsByDefault(): void
    {
        IntegerConversion::factory()->count(20)->create();

        $response = $this->getJson($this->uri);

        $response->assertJsonStructure([
            'data' => [
                [
                    'integer_value',
                    'converted_value',
                    'times_converted',
                    'first_converted',
                    'last_converted',
                ]
            ]
        ])
            ->assertJsonCount(10, 'data');

        foreach (IntegerConversion::orderBy('updated_at', 'DESC')->limit(10)->get() as $index => $conversion) {
            $response->assertJsonPath("data.$index.integer_value", $conversion->integer_value);
        }
    }

    /**
     * @dataProvider provideInvalidLimits
     *
     * @param mixed $invalidLimit
     * @param string $validationMessage
     */
    public function testReturnsUnprocessableEntityResponseOnInvalidLimit($invalidLimit, string $validationMessage): void
    {
        $response = $this->getJson($this->uri . "?limit=$invalidLimit");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['limit' => $validationMessage]);
    }

    public function provideInvalidLimits(): array
    {
        return [
            'not an integer'        => ['foo', 'The limit must be an integer.'],
            'integer below minimum' => [0, 'The limit must be at least 1.'],
        ];
    }

    public function testReturnsLatestConversionsLimitedByQueryParam(): void
    {
        IntegerConversion::factory()->count(10)->create();

        $response = $this->getJson($this->uri . '?limit=5');

        $response->assertJsonCount(5, 'data');

        foreach (IntegerConversion::orderBy('updated_at', 'DESC')->limit(5)->get() as $index => $conversion) {
            $response->assertJsonPath("data.$index.integer_value", $conversion->integer_value);
        }
    }
}
