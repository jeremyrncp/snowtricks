<?php

namespace App\Repository;

use App\Entity\Comments;
use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public const DEFAULT_lENGTH = 10;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    /**
     * @param Trick $trick
     *
     * @return QueryBuilder
     */
    public function findCommentsByTrick(Trick $trick)
    {
        return $this->createQueryBuilder('c')
                    ->select('c')
                    ->where('c.Trick = :trick')
                    ->orderBy('c.id','DESC')
                    ->setParameter('trick', $trick)
            ;
    }
}
