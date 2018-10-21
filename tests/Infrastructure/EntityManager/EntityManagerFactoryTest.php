<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Infrastructure\EntityManager;

use App\Exception\InfrastructureAdapterException;
use App\Infrastructure\EntityManager\EntityManagerFactory;
use App\Infrastructure\InfrastructureEntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityManagerFactoryTest extends KernelTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }
    public function testShouldObtainAValidDoctrineEntityManager()
    {
        $entityManagerFactory = new EntityManagerFactory(self::$container->get("doctrine")->getManager());
        $this->assertInstanceOf(InfrastructureEntityManagerInterface::class, $entityManagerFactory->create("Doctrine"));
    }
    public function testShouldObtainAnErrorWhenEntityManagerIsntExist()
    {
        $this->expectException(InfrastructureAdapterException::class);

        $entityManagerFactory = new EntityManagerFactory(self::$container->get("doctrine")->getManager());
        $entityManagerFactory->create("PHPUNIT");
    }
}
