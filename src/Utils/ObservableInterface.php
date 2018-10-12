<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 15:15
 */

namespace App\Utils;

interface ObservableInterface
{
    public function addObservator(ObservatorInterface $observator);
    public function deleteObservator(ObservatorInterface $observator);
    public function notifyObservator();
}
