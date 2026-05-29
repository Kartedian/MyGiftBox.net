<?php

namespace Dwm\MyGiftBox\webui\provider;

use Dwm\MyGiftBox\application_core\application\usecases\AuthnService;

class AuthnProvider
{
    public static function register(string $email, string $password): bool
    {
        return AuthnService::register($email, $password);
    }

    public static function authenticate(string $email, string $password): bool
    {
        return AuthnService::authenticate($email, $password);
    }

    public static function logout(): void
    {
        AuthnService::logout();
    }
}