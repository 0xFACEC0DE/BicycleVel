<?php

namespace Bicycle\Services\UserActivation;

use Bicycle\Models\User;

class UserActivationService
{
    private static $table = 'users_activation_codes';

    public static function checkActivationCode(User $user, string $code): bool
    {
        $sql = 'SELECT * FROM `' . self::$table . '` WHERE user_id = :user_id AND code = :code';
        $result = db()->exec($sql,[
                'user_id' => $user->id,
                'code' => $code
            ]
        );
        return !empty($result);
    }

    private static function storeActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));
        $sql = 'INSERT INTO `' . self::$table . '` (user_id, code) VALUES (:user_id, :code)';
        db()->exec($sql,[
                'user_id' => $user->id,
                'code' => $code
            ]
        );
        return $code;
    }

    public static function clearActivationCode($code)
    {
        $sql = 'DELETE FROM `' . self::$table . '` WHERE code = :code';
        return db()->exec($sql, ['code' => $code]);
    }

    private static function getMailer(array $config)
    {
        $transport = (new Swift_SmtpTransport($config['host'], $config['port'], $config['encryption']))
            ->setUsername($config['username'])
            ->setPassword($config['password']);

        return new Swift_Mailer($transport);
    }

    public static function sendActivationMail(User $receiver, string $subject, string $templateName)
    {
        $activationCode = self::storeActivationCode($receiver);
        $activationlink = url() . '/user/' . $receiver->id . '/activate/' . $activationCode;
        $mailBody = view()->html($templateName, compact('activationlink'));
        $config = config()['mailing'];
        $mailer = self::getMailer($config);

        $message = (new Swift_Message($subject))
            ->setFrom($config['sender'])
            ->setTo([$receiver->email])
            ->setBody($mailBody, 'text/html');

        return $mailer->send($message);
    }
}