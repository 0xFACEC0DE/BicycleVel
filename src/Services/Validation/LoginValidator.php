<?php

namespace Bicycle\Services\Validation;

class LoginValidator extends Validator
{
    public static function validate(array $data): array
    {
        if (!empty($messages = self::validateEmpty($data))) {
            return $messages;
        }
        $messages += self::validateSize($data);

        $rules = [
            [empty($data['email']),
                'Enter email'],

            [empty($data['password']),
                'Enter password'],
        ];

        $messages += self::evaluateRules($rules);

        return $messages;
    }
}