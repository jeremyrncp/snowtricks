<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Utils;


use Symfony\Component\HttpFoundation\Request;

class GlobalUtils
{
    /**
     * @return Request
     */
    private static function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    /**
     * @return null|string
     */
    public static function getIp(): ?string
    {
        return self::getRequest()->getClientIp();
    }
}
