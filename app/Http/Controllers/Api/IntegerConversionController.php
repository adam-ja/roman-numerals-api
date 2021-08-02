<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IntegerConversionRequest;
use App\Http\Requests\LimitedCollectionRequest;
use App\Http\Resources\IntegerConversionResource;
use App\Models\IntegerConversion;
use App\Services\IntegerConverterInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IntegerConversionController extends Controller
{
    private const DEFAULT_COLLECTION_LIMIT = 10;

    public function convert(
        IntegerConversionRequest $request,
        IntegerConverterInterface $converter
    ): IntegerConversionResource {
        $integer = $request->input('integer');

        /** @var IntegerConversion $conversion */
        $conversion = IntegerConversion::where('integer_value', $integer)->firstOr(
            fn() => (IntegerConversion::create([
                'integer_value'   => $integer,
                'converted_value' => $converter->convertInteger($integer),
            ]))
        );

        if (! $conversion->wasRecentlyCreated) {
            $conversion->increment('conversion_count');
        }

        return new IntegerConversionResource($conversion);
    }

    public function latest(LimitedCollectionRequest $request): AnonymousResourceCollection
    {
        return IntegerConversionResource::collection(
            IntegerConversion::orderBy('updated_at', 'DESC')
                ->limit($request->input('limit', self::DEFAULT_COLLECTION_LIMIT))
                ->get()
        );
    }

    public function mostPopular(LimitedCollectionRequest $request): AnonymousResourceCollection
    {
        return IntegerConversionResource::collection(
            IntegerConversion::orderBy('conversion_count', 'DESC')
                ->limit($request->input('limit', self::DEFAULT_COLLECTION_LIMIT))
                ->get()
        );
    }
}
