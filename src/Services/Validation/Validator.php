<?php

namespace Bicycle\Services\Validation;

abstract class Validator
{
    /**
     * Checks rules first value as expression and return second value as message for evaluated to true expressions
     * @param array $rules
     * @return array|null
     */
    public static function evaluateRules(array $rules): array
    {
        $errorMessages = [];
        foreach ($rules as $expression) {
            if ($expression[0]) {
                $errorMessages[] = $expression[1];
            }
        }
        return $errorMessages;
    }

    public static function validateSize(array $data): array
    {
        $isTooLong = false;
        foreach ($data as $value) {
            if (mb_strlen($value) > 190) {
                $isTooLong = true;
                break;
            }
        }
        $rules[] = [$isTooLong, 'Length of each value must be less then 190 characters'];

        return self::evaluateRules($rules);
    }

    public static function validateEmpty(array $data): array
    {
        $rules = [
            [empty($data), 'Fullfill all form fields']
        ];

        return self::evaluateRules($rules);
    }

    abstract public static function validate(array $data): array;
}