<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Generic;

class EncryptionServicesGeneric
{
    /**
     * @param string $hash
     * @param string $password
     *
     * @return bool
     */
    public static function verifyPassword(string $hash, string $password): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * @param string $password
     * @return string
     */
    public static function passwordEncrypt(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
