<?php

namespace Bicycle\Models;

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
}