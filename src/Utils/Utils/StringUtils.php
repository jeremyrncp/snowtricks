<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Utils;


class StringUtils
{
    public static function getToken(): string
    {
        return sha1(
            time() . rand()
        );
    }
}