<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
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
