<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }


    /**
     * @param string $email
     * @return User|null|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function loadUserByUsername($email)
    {
        return $this->findOneBy(
            ["email" => $email]
        );
    }

    /**
     * @param User $user
     * @return User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByEmailAndUserName(User $user)
    {

        $query = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.email = :email')
            ->orWhere('u.userName = :userName')
            ->setParameters(
                [
                    'email' => $user->getEmail(),
                    'userName' => $user->getUserName()
                ]
            )
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
