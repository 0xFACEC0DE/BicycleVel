<?php /** @noinspection ALL */

namespace Bicycle\Controllers;

use Bicycle\Models\User;
use Bicycle\Lib\App;
use Bicycle\Services\UserActivation\UserActivationService;
use Bicycle\Services\Validation\LoginValidator;
use Bicycle\Services\Validation\RegisterValidator;

class AuthController extends Controller
{
    public function register()
    {
        if (!empty($errorMessages = RegisterValidator::validate($_POST))) {
            session()->set('previous', $_POST);
            session()->set('errors', $errorMessages);
            response()->redirect('/user/signup');
        };

        if (!$user = User::create($_POST)) {
            session()->set('previous', $_POST);
            session()->set('errors', ['server error, user not registered']);
            response()->redirect('/user/signup');
        }

        App::addPostAction(function () use ($user) {
            UserActivationService::sendActivationMail($user, 'Активация', 'mail/userActivation');
        });
        session()->set('id', $user->id);
        return view()->layoutHtml('users/signUpSuccess');
    }

    public function login()
    {
        if ($errorMessages = LoginValidator::validate($_POST)) {
            session()->set('previous', $_POST);
            session()->set('errors', $errorMessages);
            response()->redirect('/user/signin');
        }

        if (!$user = User::loginBy($_POST, 'email')) {
            session()->set('previous', $_POST);
            session()->set('errors', ['User with such credentials not found']);
            response()->redirect('/user/signin');
        }

        $user->saveAuthorization();
        response()->redirect('/');
    }

    public function logout()
    {
        session()->clean();
        response()->redirect('/');
    }
}