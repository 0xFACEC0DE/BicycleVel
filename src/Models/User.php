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
        self::validateInput($data);

        $user = new User();
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->auth_token = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $result = $user->save();
        if ($result) {
            return $user;
        }
        return null;
    }

    public static function validateInput(array $data)
    {
        $rules[] = [(empty($data['nickname'])) , 'Не передан nickname'];

        if (empty($data['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        if (!preg_match('/[a-zA-Z0-9]+/', $data['nickname'])) {
            throw new InvalidArgumentException('Nickname может состоять только из символов латинского алфавита и цифр');
        }

        if (self::find($data['nickname'], 'nickname')) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }
        
        if (empty($data['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        if (self::find($data['email'], 'email')) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        if (empty($data['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        if (mb_strlen($data['password']) < 6) {
            throw new InvalidArgumentException('Пароль должен быть не менее 6 символов');
        }
    }
}