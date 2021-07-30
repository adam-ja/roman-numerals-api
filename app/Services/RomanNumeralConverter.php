<?php

namespace App\Services;

class RomanNumeralConverter implements IntegerConverterInterface
{
    private const MAP = [
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1,
    ];

    public function convertInteger(int $integer): string
    {
        $converted = '';

        foreach (self::MAP as $romanNumeral => $value) {
            if ($integer < $value) {
                continue;
            }

            $converted .= str_repeat($romanNumeral, (int) floor($integer / $value));

            $integer = $integer % $value;

            if ($integer === 0) {
                break;
            }
        }

        return $converted;
    }
}
