<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 15:03
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