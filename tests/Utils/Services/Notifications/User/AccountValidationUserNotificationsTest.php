<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 13/10/2018
 * Time: 12:18
 */

namespace App\Tests\Utils\Services\Notifications\User;

use App\Entity\User;
use App\Exception\EntityNotValidException;
use App\Exception\UndefinedEntityException;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Utils\Services\Notifications\User\AccountValidationUserNotifications;
use PHPUnit\Framework\TestCase;

class AccountValidationUserNotificationsTest extends TestCase
{

    public function testShouldObtainAsuccessWhenUserEntityIsValidAndNotificationCorrectlySent()
    {
        $accountValidationUserNotifications = $this->getAccountValidationUserNotifications();
        $accountValidationUserNotifications->setUser($this->getUserEntityValid());
        $this->assertNull(
            $accountValidationUserNotifications->send()
        );
    }
    public function testShouldObtainAnErrorWhenUserEntityIsntValid()
    {
        $this->expectException(EntityNotValidException::class);

        $accountValidationUserNotifications = $this->getAccountValidationUserNotifications();
        $accountValidationUserNotifications->setUser($this->getUserEntityInvalid());
        $accountValidationUserNotifications->send();
    }
    public function testShouldObtainAnErrorWhenEntityIsntDefined()
    {
        $this->expectException(UndefinedEntityException::class);

        $accountValidationUserNotifications = $this->getAccountValidationUserNotifications();
        $accountValidationUserNotifications->send();
    }

    /**
     * @return AccountValidationUserNotifications
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function getAccountValidationUserNotifications()
    {
        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory->create();

        return new AccountValidationUserNotifications($validator);
    }

    /**
     * @return User
     */
    public function getUserEntityInvalid()
    {
        $user = new User();
        $user->setDateCreate(new \DateTime());
        $user->setEmail("contact@test.com");
        $user->setPassword("test");
        $user->setLastName("test");
        $user->setFirstName("test");
        $user->setState(User::USER_EMAIL_VALID);
        $user->setUserName("test");

        return $user;
    }
    /**
     * @return User
     */
    public function getUserEntityValid()
    {
        $user = new User();
        $user->setDateCreate(new \DateTime());
        $user->setEmail("contact@test.com");
        $user->setPassword("test");
        $user->setLastName("test");
        $user->setFirstName("test");
        $user->setState(User::USER_EMAIL_VALID);
        $user->setUserName("test");
        $user->setToken("test");

        return $user;
    }
}
