<?php

namespace Bicycle\Models;

use Bicycle\Lib\App;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected static $table = 'users';

    /** @var string */
    public $name;

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
     */
    public static function create(array $data)
    {
        $user = new self;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->auth_token = sha1(random_bytes(64)) . sha1(random_bytes(64));

        return $user->save() ? $user : null;
    }

    public static function authorized()
    {
        if ( !($identity = App::session()->get('identity')) || !($user = self::findOne($identity['id'])) ) {
            return false;
        };

        return ($user->auth_token === $identity['auth_token']) ? $user : false;
    }

    public function saveAuthorization()
    {
        $identity['auth_token'] = $this->auth_token;
        $identity['id'] = $this->id;
        App::session()->set('identity', $identity);
    }

    public static function loginBy(array $data, string $property)
    {
        if (!$user = self::findOne($data['email'], $property)) {
            return false;
        }

        return password_verify($data['password'], $user->password_hash) ? $user : false;
    }

    public function activate()
    {
        $this->is_confirmed = 1;
        return $this->save();
    }
}