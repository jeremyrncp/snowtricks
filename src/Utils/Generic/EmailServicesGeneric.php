<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Generic;

use App\Exception\EmailInvalidException;
use Respect\Validation\Validator;

class EmailServicesGeneric
{

    /**
     * @param string $email
     *
     * @return bool
     *
     * @throws EmailInvalidException
     */
    public static function validateEmail(string $email): bool
    {
        if (!Validator::email() -> validate($email)) {
            throw new EmailInvalidException($email . " isn't valid");
        }

        return true;
    }
}
