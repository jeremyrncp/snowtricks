<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services\Trick;


use App\Entity\Trick;
use App\Repository\TrickRepository;

class TrickServices
{
    const START = 0;
    const LENGTH = 10;

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * TrickServices constructor.
     * @param TrickRepository $trickRepository
     */
    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }

    /**
     * @param int|null $start
     * @param int|null $length
     *
     * @return Trick[]
     */
    public function getTricks(int $start = self::START, int $length = self::LENGTH)
    {
        return $this->trickRepository
            ->createQueryBuilder("t")
            ->setFirstResult($start)
            ->setMaxResults($length)
            ->getQuery()
            ->getResult();
    }
}
