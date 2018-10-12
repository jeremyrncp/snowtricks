<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 15:19
 */

namespace App\Utils;

use App\Exception\AlreadyExistException;
use App\Exception\EmptyException;
use App\Exception\NotExistException;

trait ObservableTrait
{
    /**
     * @var ObservatorInterface[]
     */
    private $observatorCollection = [];

    /**
     * @param ObservatorInterface $observator
     * @throws AlreadyExistException
     */
    public function addObservator(ObservatorInterface $observator)
    {
        $this->isNotExistObservator($observator);

        $this->observatorCollection[
            $this->getClassNameObservator($observator)
        ] = $observator;
    }

    /**
     * @param ObservatorInterface $observator
     * @throws NotExistException
     */
    public function deleteObservator(ObservatorInterface $observator)
    {
        $this->isExistObservator($observator);

        unset(
            $this->observatorCollection[
                $this->getClassNameObservator($observator)
            ]
        );
    }

    /**
     * @param ObservatorInterface $observator
     * @return string
     */
    private function getClassNameObservator(ObservatorInterface $observator): string
    {
        return get_class($observator);
    }

    /**
     * Notify observator
     */
    public function notifyObservator()
    {
        $this->notifyObservatorCollection(
            $this->observatorCollection
        );
    }

    /**
     * @throws EmptyException
     */
    public function isNotEmptyCollection(): void
    {
        if (empty($this->observatorCollection)) {
            throw new EmptyException(
                "Your notify observator collection is empty, please add observator before notify them"
            );
        }
    }

    /**
     * @param ObservatorInterface $observator
     * @throws NotExistException
     */
    public function isExistObservator(ObservatorInterface $observator): void
    {
        if (!key_exists(
            $this->getClassNameObservator($observator),
            $this->observatorCollection
        )) {
            throw new NotExistException("This observator isn't exist");
        }
    }

    /**
     * @param ObservatorInterface $observator
     * @throws AlreadyExistException
     */
    public function isNotExistObservator(ObservatorInterface $observator): void
    {
        if (key_exists(
            $this->getClassNameObservator($observator),
            $this->observatorCollection
        )) {
            throw new AlreadyExistException("Observator already exist in collection");
        }
    }

    /**
     * @param ObservatorInterface[] $collection
     */
    private function notifyObservatorCollection(array $collection)
    {
        $observator = current($collection);
        $observator->process($this);

        if (false !== next($collection)) {
            $this->notifyObservatorCollection($collection);
        }
    }
}
