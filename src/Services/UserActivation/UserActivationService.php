<?php

namespace Bicycle\Services\UserActivation;

use Bicycle\Lib\App;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
use Bicycle\Models\User;


class UserActivationService
{
    private static $table = 'users_activation_codes';

    public static function checkActivationCode(User $user, string $code): bool
    {
        $sql = 'SELECT * FROM ' . self::$table . ' WHERE user_id = :user_id AND code = :code';
        $result = App::db()->exec($sql,[
                'user_id' => $user->id,
                'code' => $code
            ]
        );
        return !empty($result);
    }

    private static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));
        $sql = 'INSERT INTO ' . self::$table . ' (user_id, code) VALUES (:user_id, :code)';
        App::db()->exec($sql,[
                'user_id' => $user->id,
                'code' => $code
            ]
        );
        return $code;
    }

    private static function createActivationLink($userId, $code)
    {
        $url = $_SERVER['HTTPS'] ? 'https://' : 'http://';
        $url .= $_SERVER['SERVER_NAME'];
        return "$url/user/$userId/activate/$code";
    }

    private static function getMailer($config)
    {
        $transport = (new Swift_SmtpTransport($config['host'], $config['port'], $config['encryption']))
            ->setUsername($config['username'])
            ->setPassword($config['password']);

        return new Swift_Mailer($transport);
    }

    public static function sendActivationMail(User $receiver, string $subject, string $templateName)
    {
        $code = self::createActivationCode($receiver);
        $link = self::createActivationLink($receiver->id, $code);

        $body = App::view()->html($templateName, compact('link'));

        $config = App::config()['mailing'];

        $mailer = self::getMailer($config);

        $message = (new Swift_Message($subject))
            ->setFrom($config['sender'])
            ->setTo([$receiver->email])
            ->setBody($body, 'text/html');

        return $mailer->send($message);
    }
}