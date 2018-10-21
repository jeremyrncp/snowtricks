<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Utils\Services\User;

use App\Entity\User;
use App\Exception\TokenAlreadyUsedException;
use App\Exception\UnknownParameterException;
use App\Infrastructure\EntityManager\DoctrineEntityManager;
use App\Repository\UserRepository;
use App\Utils\Services\User\ValidationUserServices;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class ValidationUserServicesTest extends TestCase
{
    public function testShouldObtainASuccessWhenTokenIsValidAndUserUpdated()
    {
        $validationUserServices = new ValidationUserServices(
            $this->getMockRepositoryWhenTokenIsUsable(),
            $this->getMockEntityManager()
        );
        $this->assertNull(
            $validationUserServices->validationWithToken("de932bb7f33882a66ba8e81952c16b6b1ec40095")
        );
    }
    public function testShouldObtainAnErrorWhenTokenIsValidButAccountIsAlreadyValid()
    {
        $this->expectException(TokenAlreadyUsedException::class);

        $validationUserServices = new ValidationUserServices(
            $this->getMockRepositoryWhenTokenIsAlreadyUsed(),
            $this->getMockEntityManager()
        );
        $validationUserServices->validationWithToken("de932bb7f33882a66ba8e81952c16b6b1ec40095");
    }
    public function testShouldObtainAnErrorWhenTokenIsntValid()
    {
        $this->expectException(InvalidParameterException::class);
        $validationUserServices = new ValidationUserServices(
            $this->getMockRepositoryWhenTokenIsntFound(),
            $this->getMockEntityManager()
        );
        $validationUserServices->validationWithToken("validToken");
    }
    public function testShouldObtainAnErrorWhenTokenIsntFound()
    {
        $this->expectException(UnknownParameterException::class);

        $validationUserServices = new ValidationUserServices(
            $this->getMockRepositoryWhenTokenIsntFound(),
            $this->getMockEntityManager()
        );
        $validationUserServices->validationWithToken("de932bb7f33882a66ba8e81952c16b6b1ec40095");
    }

    private function getMockEntityManager()
    {
        return $this->createMock(DoctrineEntityManager::class);
    }
    private function getMockRepositoryWhenTokenIsUsable()
    {
        $user = new User();
        $user->setState(User::USER_EMAIL_INVALID);

        $mockRepository = $this->createMock(UserRepository::class);
        $mockRepository->method("findOneBy")
            ->willReturn($user);

        return $mockRepository;
    }
    private function getMockRepositoryWhenTokenIsAlreadyUsed()
    {

        $user = new User();
        $user->setState(User::USER_EMAIL_VALID);

        $mockRepository = $this->createMock(UserRepository::class);
        $mockRepository->method("findOneBy")
            ->willReturn($user);

        return $mockRepository;
    }
    private function getMockRepositoryWhenTokenIsntFound()
    {
        $mockRepository = $this->createMock(UserRepository::class);
        $mockRepository->method("findOneBy")
                        ->willReturn(null);

        return $mockRepository;
    }
}
