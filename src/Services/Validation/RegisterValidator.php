<?php

namespace Bicycle\Services\Validation;

use Bicycle\Models\User;

class RegisterValidator extends Validator
{
    public static function validate(array $data): array
    {
        if (!empty($messages = self::validateEmpty($data))) {
            return $messages;
        }

        $rules = [
            [empty($data['name']),
                'Enter name'],

            [empty($data['password']),
                'Enter password'],

            [mb_strlen($data['password']) < 6,
                'Password must contain at least 6 characters'],

            [!preg_match('/^\p{L}+$/u',$data['name']),
                'Only letters allowed in name'],

            [empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL),
                'Enter valid email'],

            [User::findOne($data['email'], 'email'),
                'User with this email already exists, enter another email'],
        ];

        $messages += self::validateSize($data);
        $messages += self::evaluateRules($rules);

        return $messages;
    }
}