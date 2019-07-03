<?php

namespace Bicycle\Controllers;

use Bicycle\Models\User;

abstract class Controller
{
    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = User::authorized();
        view()->setVar('user', $this->user);
    }
}