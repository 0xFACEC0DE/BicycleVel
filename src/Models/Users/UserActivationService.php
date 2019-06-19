<?php

namespace Bicycle\Models\Users;

use Bicycle\Lib\App;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class UserActivationService
{
    private const TABLE_NAME = 'users_activation_codes';

    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));
        $sql = 'INSERT INTO ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)';
        App::db()->exec($sql,[
                'user_id' => $user->id,
                'code' => $code
            ]
        );
        return $code;
    }

    public static function checkActivationCode(User $user, string $code): bool
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code';
        $result = App::db()->exec($sql,[
                'user_id' => $user->id,
                'code' => $code
            ]
        );
        return !empty($result);
    }

    public static function sendActivationMail(User $receiver, string $subject, string $templateName, array $templateVars = [])
    {
        $body = App::view()->partialHtml($templateName, $templateVars);

        $c = App::config()['mailing'];
        $transport = (new Swift_SmtpTransport($c['host'], $c['port'], $c['encryption']))
            ->setUsername($c['username'])
            ->setPassword($c['password']);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message($subject))
            ->setFrom($c['sender'])
            ->setTo([$receiver->email])
            ->setBody($body, 'text/html');

        return $mailer->send($message);
    }
}