<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Infrastructure\EntityManager;

use App\Exception\ORMException;
use PHPUnit\Framework\TestCase;

class EntityManagerORMEntityManagerExceptionTraitImplementationTest extends TestCase
{
    public function testShouldObtainASuccessWhenAVoidWhenORMActionSuccessfullyRolledOut()
    {
        $entityManagerORMExceptionTraitImplementation = new EntityManagerORMExceptionTraitImplementation();
        $this->assertNull($entityManagerORMExceptionTraitImplementation->standardizeORMException(
            array($this,"methodVoid")
        ));
    }
    public function testShouldObtainAnErrorWhenErrorOccurredInORMAction()
    {
        $this->expectException(ORMException::class);

        $entityManagerORMExceptionTraitImplementation = new EntityManagerORMExceptionTraitImplementation();
        $entityManagerORMExceptionTraitImplementation->standardizeORMException(
            array($this,"methodThrowException")
        );
    }

    public function methodVoid()
    {
    }

    /**
     * @throws \Exception
     */
    public function methodThrowException()
    {
        throw new \Exception("Test");
    }
}
