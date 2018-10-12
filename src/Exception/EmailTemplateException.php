<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 15:38
 */

namespace App\Exception;


use Throwable;

class EmailTemplateException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}