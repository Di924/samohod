<?php

namespace classes;

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once BASE_PATH . 'classes/User.php';

use classes\User;

class FormHandler
{
    public static function signup(string $fname, string $mname, string $lname, string $email, string $password, string $repeat_password): bool
    {
        if (mb_strlen($password) < 8) return false;
        if ($password !== $repeat_password) return false;
        
        $user = User::createUser($fname, $mname, $lname, $email, $password);

        if ($user->isNull()) return false;

        self::fillSession($user);

        return true;
    }

    public static function signin(string $email, string $password): bool
    {   
        $user = User::findOne($email);

        if ($user->isNull()) return false;
        if (!password_verify($password, $user->getPassword())) return false;
        
        self::fillSession($user);

        return true;
    }
    
    public static function signout(): void
    {
        self::clearSession();
    }

    private static function fillSession(User $user): void
    {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'fname' => $user->getFname(),
            'mname' => $user->getMname(),
            'lname' => $user->getLname(),
            'email' => $user->getEmail(),
            'fullname' => $user->getFullName(),
            'role_id' => $user->getRoleId(),
        ];
    }

    private static function clearSession(): void
    {
        $_SESSION['user'] = [];
    }
}
