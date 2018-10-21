<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Utils\Services\User;

use App\Exception\UnknownParameterException;
use App\Utils\Services\User\ValidationUserServices;
use PHPUnit\Framework\TestCase;

class ValidationUserServicesTest extends TestCase
{
    public function testShouldObtainAnErrorWhenKeyIsntValid()
    {
        $this->expectException(UnknownParameterException::class);

        $validationUserServices = new ValidationUserServices();
        $validationUserServices->validationWithToken("UnknownToken");
    }
}
