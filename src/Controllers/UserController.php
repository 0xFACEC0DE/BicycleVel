<?php

namespace Bicycle\Controllers;

use Bicycle\Lib\App;
use Bicycle\Models\Users\User;
use Bicycle\Models\Users\UserActivationService;
use Bicycle\Exceptions\InvalidArgumentException;

class UserController
{
    public function register()
    {
        if (!empty($_POST)) {
            try {
                $user = User::create($_POST);
            } catch (InvalidArgumentException $e) {
                return App::view()->html('users/signUp', ['error' => $e->getMessage()]);
            }
            if ($user instanceof User) {

                App::session()->set('id', $user->id);
                UserActivationService::sendActivationMail($user,
                    'Активация',
                    'mail/userActivation',
                     [
                    'userId' => $user->id,
                    'code' => UserActivationService::createActivationCode($user),
                    'url' => App::config()['mailing']['my_url']
                ]);

                return App::view()->html('users/signUpSuccess');
            }
        } else {
            return $this->signUp();
        }
    }

    public function signUp()
    {
        return App::view()->html('users/signUp');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::findOrDie($userId);
        App::session()->set('id', $user->id);

        if (UserActivationService::checkActivationCode($user, $activationCode)) {
            if ($user->activate()) {
                App::session()->set('auth_token', $user->auth_token);
                return App::view()->html('users/activateSuccess');
            }

        }
        return App::view()->html('users/activateFail');
    }

    public function resend()
    {
        $userId = App::session()->get('id');
        if (!$userId) App::abortWithErrorPage('пользователь не найден');
        $user = User::findOrDie($userId, 'id', 'пользователь не найден');

        UserActivationService::sendActivationMail($user,
            'Активация',
            'mail/userActivation',
            [
                'userId' => $user->id,
                'code' => UserActivationService::createActivationCode($user),
                'url' => App::config()['mailing']['my_url']
            ]);
        return App::view()->html('users/signUpSuccess', ['resended' => 'повторно']);
    }
}