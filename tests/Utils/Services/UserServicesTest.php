<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 11:51
 */

namespace App\Tests\Utils\Services;

use App\Exception\InvalidFieldException;
use App\Exception\UserEmailAlreadyUsedException;
use App\Exception\UserUserNameAlreadyUsedException;
use App\Infrastructure\EntityManager\DoctrineEntityManager;
use App\Infrastructure\Mailer\MailerFactory;
use App\Infrastructure\Render\RenderFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Repository\UserRepository;
use App\Utils\Services\Notifications\User\AccountValidationUserNotifications;
use App\Utils\Services\User\UserServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserServicesTest extends KernelTestCase
{

    public function setUp()
    {
        self::bootKernel();
    }

    public function testShouldObtainAnErrorWhenUsernameAlreadyUsed()
    {
        $this->expectException(UserUserNameAlreadyUsedException::class);

        $UserServices = new UserServices(
            $this -> getMockRepositoryWithFindUser(
                $this->getUserAlreadyRegister()
            ),
            $this->getAccountValidationUserNotifications(),
            $this->getEntityManager()
        );
        $user = $this->getUserAlreadyRegister();
        $user->setEmail("emailnotused@test.com");
        $UserServices->register($user);
    }
    public function testShouldObtainAnErrorWhenEmailIsAlreadyUsed()
    {
        $this->expectException(UserEmailAlreadyUsedException::class);

        $UserServices = new UserServices(
            $this -> getMockRepositoryWithFindUser(
                $this->getUserAlreadyRegister()
            ),
            $this->getAccountValidationUserNotifications(),
            $this->getEntityManager()
        );
        $UserServices->register($this->getUserAlreadyRegister());
    }

    private function getMockRepositoryWithFindUser(\App\Entity\User $user)
    {
        $mockUserRepository = $this->createMock(UserRepository::class);
        $mockUserRepository->method("findUserByEmailAndUserName")
                           ->willReturn($user);

        return $mockUserRepository;
    }
    private function getAccountValidationUserNotifications()
    {
        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory->create();

        $mailerFactory = new MailerFactory(self::$container);
        $mailer = $mailerFactory->create("Logger");

        $renderFactory = new RenderFactory(self::$container);
        $render = $renderFactory->create();

        return new AccountValidationUserNotifications(
            $validator,
            $mailer,
            $render
        );
    }
    private function getUserAlreadyRegister()
    {
        $user = new \App\Entity\User();
        $user -> setDateCreate(new \DateTime());
        $user -> setEmail("contact@test.com");
        $user -> setFirstName("Martin");
        $user -> setLastName("Durand");
        $user -> setPassword("validpassword");
        $user -> setUserName("phpunit");

        return $user;
    }
    private function getEntityManager()
    {
        return $this->createMock(DoctrineEntityManager::class);
    }
}
