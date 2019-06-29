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
            App::session()->set('previous', $_POST);
            App::session()->set('errors', $errorMessages);
            App::response()->redirect('/user/signup');
        };

        if ($user = User::create($_POST)) {
            UserActivationService::sendActivationMail($user, 'Активация', 'mail/userActivation');
            App::response()->redirect('/user/signup/success');

        } else {
            App::session()->set('previous', $_POST);
            App::session()->set('errors', ['server error, user not registered']);
            App::response()->redirect('/user/signup');
        }
    }

    public function login()
    {
        if ($errorMessages = LoginValidator::validate($_POST)) {
            App::session()->set('previous', $_POST);
            App::session()->set('errors', $errorMessages);
            App::response()->redirect('/user/signin');
        }

        if (!$user = User::loginBy($_POST, 'email')) {
            App::session()->set('previous', $_POST);
            App::session()->set('errors', ['User with such credentials not found']);
            App::response()->redirect('/user/signin');
        }

        $user->saveAuthorization();
        App::response()->redirect('/');
    }

    public function logout()
    {
        App::session()->clean();
        App::response()->redirect('/');
    }
}