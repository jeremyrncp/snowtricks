<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Utils;

interface ObservatorInterface
{
    public function process(ObservableInterface $observable);
}
