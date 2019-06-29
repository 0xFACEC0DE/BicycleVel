<?php

namespace Bicycle\Controllers;

use Bicycle\Lib\App;
use Bicycle\Models\User;
use Bicycle\Services\UserActivation\UserActivationService;

class UserController extends Controller
{
    public function profile()
    {
        if ($user = User::authorized()) {
            return App::view()->layoutHtml('users/authorized', compact('user'));
        }

        return App::view()->layoutHtml('users/notAuthorized');
    }

    public function signUp()
    {
        $errors = App::session()->get('errors');
        $previous = App::session()->get('previous');
        return App::view()->layoutHtml('users/signUp', compact(['errors', 'previous']));
    }

    public function signUpSuccess()
    {
        return App::view()->layoutHtml('users/signUpSuccess');
    }

    public function signIn()
    {
        $previous = App::session()->get('previous');
        $errors = App::session()->get('errors');
        return App::view()->layoutHtml('users/signIn', compact(['errors', 'previous']));
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::findOrDie($userId);

        if (UserActivationService::checkActivationCode($user, $activationCode) && $user->activate()) {
            return App::view()->layoutHtml('users/activateSuccess');
        } else {
            App::session()->set('id', $user->id);
            return App::view()->layoutHtml('users/activateFail');
        }
    }

    public function resend()
    {
        $user = User::findOrDie(App::session()->get('id'));

        if (UserActivationService::sendActivationMail($user, 'Активация', 'mail/userActivation')) {
            return App::view()->layoutHtml('users/signUpSuccess', ['resended' => 'повторно']);
        } else {
            App::session()->set('id', $user->id);
            return App::view()->layoutHtml('users/activateFail');
        }
    }
}