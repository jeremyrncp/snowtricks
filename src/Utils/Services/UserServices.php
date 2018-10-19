<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services;

use App\Entity\User;
use App\Exception\UserEmailAlreadyUsedException;
use App\Exception\UserUserNameAlreadyUsedException;
use App\Infrastructure\InfrastructureEntityManagerInterface;
use App\Repository\UserRepository;
use App\Utils\Services\Notifications\User\AccountValidationUserNotifications;
use App\Utils\Utils\StringUtils;

class UserServices
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AccountValidationUserNotifications
     */
    private $accountValidationUserNotifications;

    /**
     * @var InfrastructureEntityManagerInterface
     */
    private $infrastructureEntityManager;

    /**
     * UserServices constructor.
     * @param UserRepository $userRepository
     * @param AccountValidationUserNotifications $accountValidationUserNotifications
     * @param InfrastructureEntityManagerInterface $infrastructureEntityManager
     */
    public function __construct(
        UserRepository $userRepository,
        AccountValidationUserNotifications $accountValidationUserNotifications,
        InfrastructureEntityManagerInterface $infrastructureEntityManager
    ) {
        $this->userRepository = $userRepository;
        $this->accountValidationUserNotifications = $accountValidationUserNotifications;
        $this->infrastructureEntityManager = $infrastructureEntityManager;
    }

    /**
     * @param User $user
     * @throws UserEmailAlreadyUsedException
     * @throws UserUserNameAlreadyUsedException
     * @throws \App\Exception\EntityNotValidException
     * @throws \App\Exception\UndefinedEntityException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \App\Exception\ORMException
     */
    public function register(User $user)
    {
        $getUser = $this->userRepository->findUserByEmailAndUserName($user);

        if (!is_null($getUser)) {
            $this->reasonsWhyUserIsntRegistrable($user, $getUser);
        }

        $token = StringUtils::getToken();
        $user->setDateCreate(new \DateTime());
        $user->setToken($token);

        $this->infrastructureEntityManager->persist($user);
        $this->infrastructureEntityManager->flush();

        $this->accountValidationUserNotifications->setUser($user);
        $this->accountValidationUserNotifications->send();
    }

    /**
     * @param User $user
     * @param User $getUser
     * @throws UserEmailAlreadyUsedException
     */
    public function userEmailAlreadyExisted(User $user, User $getUser): void
    {
        if ($getUser->getEmail() === $user->getEmail()) {
            throw new UserEmailAlreadyUsedException("Your email is already used");
        }
    }

    /**
     * @param User $user
     * @param User $getUser
     * @throws UserUserNameAlreadyUsedException
     */
    public function userUserNameAlreadyExisted(User $user, User $getUser): void
    {
        if ($user->getUserName() === $getUser->getUserName()) {
            throw new UserUserNameAlreadyUsedException("UserName already used");
        }
    }

    /**
     * @param User $user
     * @param $getUser
     * @throws UserEmailAlreadyUsedException
     * @throws UserUserNameAlreadyUsedException
     */
    public function reasonsWhyUserIsntRegistrable(User $user, User $getUser): void
    {
        $this->userEmailAlreadyExisted($user, $getUser);
        $this->userUserNameAlreadyExisted($user, $getUser);
    }
}
