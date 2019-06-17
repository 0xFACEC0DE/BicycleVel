<?php

namespace Bicycle\Models;

use Bicycle\Exceptions\InvalidArgumentException;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected static $table = 'users';

    /** @var string */
    public $nickname;

    /** @var string */
    public $email;

    /** @var int */
    public $is_confirmed;

    /** @var string */
    public $role;

    /** @var string */
    public $password_hash;

    /** @var string */
    public $auth_token;

    /** @var string */
    public $created_at;

    /**
     * @param array $data
     * @return User|null
     * @throws InvalidArgumentException
     */
    public static function create(array $data)
    {
        $errorMessages = self::validateInput($data);
        if (!empty($errorMessages)) {
            throw new InvalidArgumentException(implode('<br/>', $errorMessages));
        };

        $user = new User();
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->auth_token = sha1(random_bytes(64)) . sha1(random_bytes(64));
        $result = $user->save();
        if ($result) {
            return $user;
        }
        return null;
    }

    public static function validateInput(array $data) : array
    {
        $rules = [
            [(empty($_POST['nickname']) && empty($_POST['email']) && empty($_POST['password'])), 'Заполните форму'],
            [(empty($data['nickname'])), 'Не передан nickname'],
            [(!preg_match('/[a-zA-Z0-9]+/',$data['nickname'])),
                'Nickname может состоять только из символов латинского алфавита и цифр'],
            [(self::find($data['nickname'], 'nickname')), 'Пользователь с таким nickname уже существует'],
            [(empty($data['email'])), 'Не передан email'],
            [(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)), 'Email некорректен'],
            [(self::find($data['email'], 'email')), 'Пользователь с таким email уже существует'],
            [(empty($data['password'])), 'Не передан password'],
            [(mb_strlen($data['password']) < 6), 'Пароль должен быть не менее 6 символов']
        ];

        if ($rules[0][0]) return [$rules[0][1]]; //если ничего не передано вернуть только первое сообщение

        $errorMessages = [];
        foreach ($rules as $expression) {
            if ($expression[0]) {
                $errorMessages[] = $expression[1];
            }
        }

        return $errorMessages;
    }
}