<?php

namespace Dwm\MyGiftBox\application_core\application\usecases;

interface AuthnServiceInterface
{
    /**
     * Enregistre un nouvel utilisateur avec le nom d'utilisateur et le mot de passe fournis.
     * @return bool Retourne true si l'enregistrement est réussi, sinon false.
     * @throws \Exception Si une erreur survient lors de l'enregistrement de l'utilisateur.
     */
    public static function register(string $email, string $password);
    
    /**
     * Authentifie un utilisateur avec le nom d'utilisateur et le mot de passe fournis.
     * @return array Returns an array with user_id and role if authentication is successful, otherwise false.
     * @throws \Exception Si une erreur survient lors de l'authentification de l'utilisateur.
     */
    public static function authenticate(string $email, string $password);
}