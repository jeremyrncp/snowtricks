<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Utils\Services\Trick;

use App\Entity\Trick;
use App\Utils\Services\Trick\TrickServices;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickServicesTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function testShouldObtainCollectionContainFiveTricks()
    {
        $trickServices = $this->getTrickServices();
        $trickCollection = $trickServices->getTricks(0, 5);

        $this->assertCount(5, $trickCollection);
        $this->assertInstanceOf(Trick::class, current($trickCollection));
    }
    public function testShouldObtainCollectionContainThreeTricks()
    {
        $trickServices = $this->getTrickServices();
        $trickCollection = $trickServices->getTricks(0, 3);

        $this->assertCount(3, $trickCollection);
        $this->assertInstanceOf(Trick::class, current($trickCollection));
    }
    public function testShouldObtainAValidCollection()
    {
        $trickServices = $this->getTrickServices();
        $trickCollection = $trickServices->getTricks();

        $this->assertCount(10, $trickCollection);
        $this->assertInstanceOf(Trick::class, current($trickCollection));
    }

    /**
     * @return TrickServices
     */
    private function getTrickServices(): TrickServices
    {
        $trickRepository = self::$container->get("doctrine")->getRepository(Trick::class);

        return new TrickServices($trickRepository);
    }
}
