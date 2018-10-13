<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 11:51
 */

namespace App\Tests\Utils\Services;

use App\Exception\UserEmailAlreadyUsedException;
use App\Exception\UserUserNameAlreadyUsedException;
use App\Repository\UserRepository;
use App\Utils\Services\UserServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\User\User;


class UserServicesTest extends KernelTestCase
{
    public function testShouldObtainAnErrorWhenUsernameAlreadyUsed()
    {
        $this->expectException(UserUserNameAlreadyUsedException::class);

        $UserServices = new UserServices($this -> getMockRepositoryWithFindUser(
            $this->getUserAlreadyRegister()
        ));
        $user = $this->getUserAlreadyRegister();
        $user->setEmail("emailnotused@test.com");
        $UserServices->register($user);
    }
    public function testShouldObtainAnErrorWhenEmailIsAlreadyUsed()
    {
        $this->expectException(UserEmailAlreadyUsedException::class);

        $UserServices = new UserServices($this -> getMockRepositoryWithFindUser(
            $this->getUserAlreadyRegister()
        ));
        $UserServices->register($this->getUserAlreadyRegister());
    }

    private function getMockRepositoryWithFindUser(\App\Entity\User $user)
    {
        $mockUserRepository = $this->createMock(UserRepository::class);
        $mockUserRepository->method("findUserByEmailAndUserName")
                           ->willReturn($user);

        return $mockUserRepository;
    }
    private function getUserAlreadyRegister()
    {
        $user = new \App\Entity\User();
        $user -> setDateCreate(new \DateTime());
        $user -> setEmail("contact@test.com");
        $user -> setFirstName("Martin");
        $user -> setLastName("Durand");
        $user -> setPassword("test");
        $user -> setUserName("phpunit");

        return $user;
    }
}
