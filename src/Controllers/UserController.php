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
            return view()->layoutHtml('users/authorized', compact('user'));
        }

        return view()->layoutHtml('users/notAuthorized');
    }

    public function signUp()
    {
        $errors = session()->get('errors');
        $previous = session()->get('previous');
        return view()->layoutHtml('users/signUp', compact(['errors', 'previous']));
    }

    public function signUpSuccess()
    {
        return view()->layoutHtml('users/signUpSuccess');
    }

    public function signIn()
    {
        $previous = session()->get('previous');
        $errors = session()->get('errors');
        return view()->layoutHtml('users/signIn', compact(['errors', 'previous']));
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::findOrDie($userId);

        if (UserActivationService::checkActivationCode($user, $activationCode) && $user->activate()) {
            UserActivationService::clearActivationCode($activationCode);
            return view()->layoutHtml('users/activateSuccess');
        } else {
            session()->set('id', $user->id);
            return view()->layoutHtml('users/activateFail');
        }
    }

    public function resend()
    {
        $user = User::findOrDie(session()->get('id'));

        if (UserActivationService::sendActivationMail($user, 'Активация', 'mail/userActivation')) {
            return view()->layoutHtml('users/signUpSuccess', ['resended' => 'повторно']);
        } else {
            return view()->layoutHtml('users/resendFail');
        }
    }
}