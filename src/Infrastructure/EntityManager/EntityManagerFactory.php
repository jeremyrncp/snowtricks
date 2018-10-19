<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Infrastructure\EntityManager;

use App\Exception\InfrastructureAdapterException;
use App\Infrastructure\InfrastructureEntityManagerInterface;
use Doctrine\ORM\EntityManager;

class EntityManagerFactory
{
    const LIST_ENTITY_MANAGER = ["Doctrine"];
    const DEFAULT_ENTITY_MANAGER = "Doctrine";

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $entityManager
     *
     * @return InfrastructureEntityManagerInterface
     *
     * @throws InfrastructureAdapterException
     */
    public function create(string $entityManager = self::DEFAULT_ENTITY_MANAGER)
    {
        $this->isValidEntityManager($entityManager);
        return $this->getDoctrineEntityManager();
    }

    /**
     * @return InfrastructureEntityManagerInterface
     */
    public function getDoctrineEntityManager()
    {
        return new DoctrineEntityManager($this->entityManager);
    }

    /**
     * @param string $entityManager
     * @throws InfrastructureAdapterException
     */
    private function isValidEntityManager(string $entityManager): void
    {
        if (!in_array($entityManager, self::LIST_ENTITY_MANAGER)) {
            throw new InfrastructureAdapterException(
                "Entity manager must be in this list " . implode(',', self::LIST_ENTITY_MANAGER)
            );
        }
    }
}