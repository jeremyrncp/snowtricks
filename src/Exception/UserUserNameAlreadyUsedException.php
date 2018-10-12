<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 14:37
 */

namespace App\Exception;


use Throwable;

class UserUserNameAlreadyUsedException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}