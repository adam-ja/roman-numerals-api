<?php

namespace Tests\Feature\Http\Controllers\Api\IntegerConversionController;

use App\Http\Resources\IntegerConversionResource;
use App\Models\IntegerConversion;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class ConvertTest extends FeatureTestCase
{
    private string $uri;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uri = route('api.integer-conversion.convert');
    }

    /**
     * @dataProvider provideInvalidIntegerValues
     *
     * @param mixed $invalidInteger
     * @param string $validationMessage
     */
    public function testReturnsUnprocessableEntityResponseOnInvalidData(
        $invalidInteger,
        string $validationMessage
    ): void {
        $response = $this->postJson($this->uri, ['integer' => $invalidInteger]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['integer' => $validationMessage]);
    }

    public function provideInvalidIntegerValues(): array
    {
        return [
            'missing integer'       => [null, 'The integer field is required.'],
            'not an integer'        => ['foo', 'The integer must be an integer.'],
            'integer below minimum' => [0, 'The integer must be between 1 and 3999.'],
            'integer above maximum' => [4000, 'The integer must be between 1 and 3999.'],
        ];
    }

    public function testRecordsNewConversion(): void
    {
        $this->postJson($this->uri, ['integer' => 10]);

        /** @var IntegerConversion|null $conversion */
        $conversion = IntegerConversion::firstWhere('integer_value', 10);

        $this->assertNotNull($conversion);
        $this->assertSame('X', $conversion->converted_value);
        $this->assertSame(1, $conversion->conversion_count);
    }

    public function testIncrementsConversionCountForRepeatConversion(): void
    {
        /** @var IntegerConversion $conversion */
        $conversion = IntegerConversion::create([
            'integer_value'    => 2021,
            'converted_value'  => 'MMXXI',
            'conversion_count' => 6,
        ]);

        $this->postJson($this->uri, ['integer' => 2021]);

        $conversion->refresh();
        $this->assertSame(7, $conversion->conversion_count);
    }

    public function testReturnsJsonResourceRepresentingConversion(): void
    {
        $response = $this->postJson($this->uri, ['integer' => 10]);

        $response->assertJsonStructure([
            'data' => [
                'integer_value',
                'converted_value',
                'times_converted',
                'first_converted',
                'last_converted',
            ]
        ]);
    }
}
