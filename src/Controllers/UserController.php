<?php

namespace Bicycle\Controllers;

use Bicycle\Services\App;
use Bicycle\Models\User;
use Bicycle\Exceptions\InvalidArgumentException;

class UserController
{
    public function register()
    {
        try {
            $user = User::create($_POST);
        } catch (InvalidArgumentException $e) {
            return App::view()->html('users/signUp', ['error' => $e->getMessage()]);
        }

        return App::view()->html('users/signUpSuccessful', ['name' => $user->nickname]);
    }

    public function signUp()
    {
        return App::view()->html('users/signUp');
    }
}