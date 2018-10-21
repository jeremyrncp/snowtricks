<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services\User;

use App\Entity\User;
use App\Exception\UserEmailAlreadyUsedException;
use App\Exception\UserUserNameAlreadyUsedException;
use App\Infrastructure\InfrastructureEntityManagerInterface;
use App\Repository\UserRepository;
use App\Utils\Generic\EncryptionServicesGeneric;
use App\Utils\Generic\Files\CopyFilesServicesGenericInterface;
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
     * @var CopyFilesServicesGenericInterface
     */
    private $copyFilesServicesGeneric;

    /**
     * UserServices constructor.
     * @param UserRepository $userRepository
     * @param AccountValidationUserNotifications $accountValidationUserNotifications
     * @param InfrastructureEntityManagerInterface $infrastructureEntityManager
     * @param CopyFilesServicesGenericInterface $copyFilesServicesGeneric
     */
    public function __construct(
        UserRepository $userRepository,
        AccountValidationUserNotifications $accountValidationUserNotifications,
        InfrastructureEntityManagerInterface $infrastructureEntityManager,
        CopyFilesServicesGenericInterface $copyFilesServicesGeneric
    ) {
        $this->userRepository = $userRepository;
        $this->accountValidationUserNotifications = $accountValidationUserNotifications;
        $this->infrastructureEntityManager = $infrastructureEntityManager;
        $this->copyFilesServicesGeneric = $copyFilesServicesGeneric;
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

        $user->setPassword(
            EncryptionServicesGeneric::passwordEncrypt($user->getPassword())
        );

        $this->copyAvatarToLocalPath($user);


        $this->infrastructureEntityManager->persist($user);
        $this->infrastructureEntityManager->flush();

        $this->sendAccountValidationNotification($user);
    }

    /**
     * @param User $user
     * @param User $getUser
     * @throws UserEmailAlreadyUsedException
     */
    private function userEmailAlreadyExisted(User $user, User $getUser): void
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
    private function userUserNameAlreadyExisted(User $user, User $getUser): void
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
    private function reasonsWhyUserIsntRegistrable(User $user, User $getUser): void
    {
        $this->userEmailAlreadyExisted($user, $getUser);
        $this->userUserNameAlreadyExisted($user, $getUser);
    }

    /**
     * @param User $user
     * @throws \App\Exception\EntityNotValidException
     * @throws \App\Exception\UndefinedEntityException
     */
    private function sendAccountValidationNotification(User $user): void
    {
        $this->accountValidationUserNotifications->setUser($user);
        $this->accountValidationUserNotifications->send();
    }

    /**
     * @param User $user
     */
    private function copyAvatarToLocalPath(User $user): void
    {
        $avatarFilePath = $this->copyFilesServicesGeneric->copyToLocalAfterCheckValidityFile(
            $user->getAvatar()
        );
        $user->setAvatar($avatarFilePath);
    }
}
