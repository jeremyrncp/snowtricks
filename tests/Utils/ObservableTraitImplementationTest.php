<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 15:25
 */

namespace App\Tests\Utils;

use App\Exception\AlreadyExistException;
use App\Exception\EmptyException;
use App\Exception\NotExistException;
use App\Utils\ObservableInterface;
use App\Utils\ObservableTrait;
use App\Utils\ObservatorInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ObservableTraitImplementationTest extends KernelTestCase
{

    public function testShouldObtainANullWhenNotifyObservator()
    {
        $observableTraitImplemention = new ObservableTraitImplementation();
        $observableTraitImplemention->addObservator(new Observator());
        $this->assertNull($observableTraitImplemention->notifyObservator());
    }
    public function testShouldObtainANullWhenDeleteObservator()
    {
        $observableTraitImplemention = new ObservableTraitImplementation();
        $observableTraitImplemention->addObservator(new Observator());
        $this->assertNull($observableTraitImplemention->deleteObservator(new Observator()));
    }
    public function testShouldObtainAnErrorWhenDeleteObservatorButObservatorIsntExist()
    {
        $this->expectException(NotExistException::class);
        $observableTraitImplemention = new ObservableTraitImplementation();
        $observableTraitImplemention->deleteObservator(new Observator());
    }
    public function testShouldObtainANullWhenAddObservator()
    {
        $observableTraitImplemention = new ObservableTraitImplementation();
        $this->assertNull(
            $observableTraitImplemention->addObservator(new Observator())
        );
    }
    public function testShouldObtainAnErrorWhenAddObservatorButObservatorIsAlreadyPresent()
    {
        $this->expectException(AlreadyExistException::class);

        $observableTraitImplemention = new ObservableTraitImplementation();
        $observableTraitImplemention->addObservator(new Observator());
        $observableTraitImplemention->addObservator(new Observator());
    }
}


class Observator implements ObservatorInterface
{
    public function process(ObservableInterface $observable)
    {
        dump("Observator is notify");
    }
}

class ObservableTraitImplementation implements ObservableInterface
{
    use ObservableTrait;
}
