<?php

namespace App\Repository;

use App\Entity\PasswordRecovery;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PasswordRecovery|null find($id, $lockMode = null, $lockVersion = null)
 * @method PasswordRecovery|null findOneBy(array $criteria, array $orderBy = null)
 * @method PasswordRecovery[]    findAll()
 * @method PasswordRecovery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordRecoveryRepository extends ServiceEntityRepository
{

    public const NUMBER_ANALYSE_HOURS = 24;

    /**
     * PasswordRecoveryRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PasswordRecovery::class);
    }

    /**
     * @param User $user
     * @param int $hoursAnalysis
     * @return int
     * @throws \Exception
     */
    public function getNumberOfRequestsByUser(User $user, int $hoursAnalysis = self::NUMBER_ANALYSE_HOURS)
    {
        $dateStart = new \DateTime();
        $dateStart->sub(new \DateInterval("PT" . $hoursAnalysis . "H"));

        return $this->createQueryBuilder('p')
                   ->select('count(p) as numberRequests')
                   ->where('p.dateCreate > :dateStart')
                   ->andWhere('p.userRelated = :user')
                   ->setParameter('dateStart', $dateStart)
                   ->setParameter('user', $user)
                   ->getQuery()
                   ->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
