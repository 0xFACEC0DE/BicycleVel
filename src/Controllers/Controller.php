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
        App::view()->setVar('user', $this->user);
    }
}