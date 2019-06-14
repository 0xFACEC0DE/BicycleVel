<?php

namespace App\Models;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected static $table = 'users';

    /** @var string */
    public $nickname;

    /** @var string */
    public $email;

    /** @var int */
    public $isConfirmed;

    /** @var string */
    public $role;

    /** @var string */
    public $passwordHash;

    /** @var string */
    public $authToken;

    /** @var string */
    public $createdAt;
}