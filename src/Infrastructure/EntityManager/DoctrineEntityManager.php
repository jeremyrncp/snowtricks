<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Infrastructure\EntityManager;

use App\Infrastructure\InfrastructureEntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

class DoctrineEntityManager implements InfrastructureEntityManagerInterface
{

    use EntityManagerORMExceptionTrait;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($className, $id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param object $object
     * @throws \App\Exception\ORMException
     */
    public function persist($object)
    {
        $this->standardizeORMException(array($this->entityManager,"persist"), $object);
    }

    /**
     * @param object $object
     * @throws \App\Exception\ORMException
     */
    public function remove($object)
    {
        $this->standardizeORMException(array($this->entityManager,"remove"), $object);
    }

    /**
     * @param object $object
     * @return object|void
     * @throws \App\Exception\ORMException
     */
    public function merge($object)
    {
        $this->standardizeORMException(array($this->entityManager,"merge"), $object);
    }

    public function clear($objectName = null)
    {
        // TODO: Implement clear() method.
    }

    /**
     * @param object $object
     * @throws \App\Exception\ORMException
     */
    public function detach($object)
    {
        $this->standardizeORMException(array($this->entityManager,"detach"), $object);
    }

    /**
     * @param object $object
     * @throws \App\Exception\ORMException
     */
    public function refresh($object)
    {
        $this->standardizeORMException(array($this->entityManager,"refresh"), $object);
    }

    /**
     * @throws \App\Exception\ORMException
     */
    public function flush()
    {
        $this->standardizeORMException(array($this->entityManager,"flush"));
    }

    public function getRepository($className)
    {
        // TODO: Implement getRepository() method.
    }

    public function getClassMetadata($className)
    {
        // TODO: Implement getClassMetadata() method.
    }

    public function getMetadataFactory()
    {
        // TODO: Implement getMetadataFactory() method.
    }

    public function initializeObject($obj)
    {
        // TODO: Implement initializeObject() method.
    }

    /**
     * @param object $object
     * @return bool|void
     * @throws \App\Exception\ORMException
     */
    public function contains($object)
    {
        $this->standardizeORMException(array($this->entityManager,"contains"), $object);
    }


    public function getCache()
    {
        // TODO: Implement getCache() method.
    }

    public function getConnection()
    {
        // TODO: Implement getConnection() method.
    }

    public function getExpressionBuilder()
    {
        // TODO: Implement getExpressionBuilder() method.
    }

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    public function transactional($func)
    {
        // TODO: Implement transactional() method.
    }

    public function commit()
    {
        $this->standardizeORMException(array($this->entityManager,"commit"));
    }

    public function rollback()
    {
        $this->standardizeORMException(array($this->entityManager,"rollback"));
    }

    public function createQuery($dql = '')
    {
        // TODO: Implement createQuery() method.
    }

    public function createNamedQuery($name)
    {
        // TODO: Implement createNamedQuery() method.
    }

    public function createNativeQuery($sql, ResultSetMapping $rsm)
    {
        // TODO: Implement createNativeQuery() method.
    }

    public function createNamedNativeQuery($name)
    {
        // TODO: Implement createNamedNativeQuery() method.
    }

    public function createQueryBuilder()
    {
        // TODO: Implement createQueryBuilder() method.
    }

    public function getReference($entityName, $id)
    {
        // TODO: Implement getReference() method.
    }

    public function getPartialReference($entityName, $identifier)
    {
        // TODO: Implement getPartialReference() method.
    }

    public function close()
    {
        // TODO: Implement close() method.
    }

    public function copy($entity, $deep = false)
    {
        // TODO: Implement copy() method.
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        // TODO: Implement lock() method.
    }

    public function getEventManager()
    {
        // TODO: Implement getEventManager() method.
    }

    public function getConfiguration()
    {
        // TODO: Implement getConfiguration() method.
    }

    public function isOpen()
    {
        // TODO: Implement isOpen() method.
    }

    public function getUnitOfWork()
    {
        // TODO: Implement getUnitOfWork() method.
    }

    public function getHydrator($hydrationMode)
    {
        // TODO: Implement getHydrator() method.
    }

    public function newHydrator($hydrationMode)
    {
        // TODO: Implement newHydrator() method.
    }

    public function getProxyFactory()
    {
        // TODO: Implement getProxyFactory() method.
    }

    public function getFilters()
    {
        // TODO: Implement getFilters() method.
    }

    public function isFiltersStateClean()
    {
        // TODO: Implement isFiltersStateClean() method.
    }

    public function hasFilters()
    {
        // TODO: Implement hasFilters() method.
    }
}
