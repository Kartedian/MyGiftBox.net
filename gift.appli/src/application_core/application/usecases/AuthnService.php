<?php

namespace Dwm\MyGiftBox\application_core\application\usecases;

use Dwm\MyGiftBox\application_core\application\usecases\AuthnServiceInterface;
use Dwm\MyGiftBox\infrastructure\User;

class AuthnService implements AuthnServiceInterface
{
    public static function register(string $email, string $password)
    {
        try {
            $user = new User();
            $user->user_id = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = 1;
            return $user->save();
        } catch (\Exception $e) { //TODO: faire c'est propre Exception
            throw new \Exception();
        }
    }

    public static function authenticate(string $email, string $password)
    {
        try {
            $user = User::where('user_id', $email)->first();
            if ($user && password_verify($password, $user->password)) {
                return ['user_id' => $user->id, 'role' => $user->role];
            }
            return false;
        } catch (\Exception $e) { //TODO: faire c'est propre Exception
            throw new \Exception();
        }
    }
}
