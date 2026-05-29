<?php

namespace Dwm\MyGiftBox\application_core\application\usecases;
use Dwm\MyGiftBox\application_core\application\usecases\AuthnServiceInterface;
use Dwm\MyGiftBox\infrastructure\User;

class AuthnService implements AuthnServiceInterface
{
    public static function register(string $email, string $password): bool
    {
        try {
            $user = new User();
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            return $user->save();
        } catch (\Exception $e) {
                throw new \Exception("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage(), 0, $e);
        }
    }

    public static function authenticate(string $email, string $password): bool
    {
        try {
            $user = User::where('email', $email)->first();
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                return true;
            }
            return false;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'authentification de l'utilisateur : " . $e->getMessage(), 0, $e);
        }
    }

    public static function logout(): void
    {
        try {
            session_unset();
            session_destroy();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la déconnexion de l'utilisateur : " . $e->getMessage(), 0, $e);
        }
    }
}