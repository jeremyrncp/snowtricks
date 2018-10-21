<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils;

interface ObservableInterface
{
    public function addObservator(ObservatorInterface $observator);
    public function deleteObservator(ObservatorInterface $observator);
    public function notifyObservator();
}
