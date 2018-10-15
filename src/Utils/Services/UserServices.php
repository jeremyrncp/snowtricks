<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 11:38
 */

namespace App\Utils\Services;

use App\Entity\User;
use App\Exception\UserEmailAlreadyUsedException;
use App\Exception\UserUserNameAlreadyUsedException;
use App\Repository\UserRepository;
use App\Utils\ObservableInterface;
use App\Utils\ObservableTrait;
use App\Utils\Utils\StringUtils;

class UserServices
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserServices constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @throws UserEmailAlreadyUsedException
     * @throws UserUserNameAlreadyUsedException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function register(User $user)
    {
        $getUser = $this->userRepository->findUserByEmailAndUserName($user);

        $this->userIsRegistrable($user, $getUser);

        $token = StringUtils::getToken();
        $user->setDateCreate(new \DateTime());
        $user->setToken($token);

        $this->userRepository->getEntityManager()->persist($user);
        $this->userRepository->getEntityManager()->flush();

        //TODO - envoyer un email de validation
    }

    /**
     * @param User $user
     * @param $getUser
     * @throws UserEmailAlreadyUsedException
     */
    public function userEmailAlreadyExisted(User $user, $getUser): void
    {
        if ($getUser->getEmail() === $user->getEmail()) {
            throw new UserEmailAlreadyUsedException("Your email is already used");
        }
    }

    /**
     * @param User $user
     * @param $getUser
     * @throws UserUserNameAlreadyUsedException
     */
    public function userUserNameAlreadyExisted(User $user, $getUser): void
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
    public function userIsRegistrable(User $user, $getUser): void
    {
        $this->userEmailAlreadyExisted($user, $getUser);

        $this->userUserNameAlreadyExisted($user, $getUser);
    }
}
