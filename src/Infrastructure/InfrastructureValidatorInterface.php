<?php

/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Infrastructure;

interface InfrastructureValidatorInterface
{
    public function validate($entity): bool;
    public function getErrors(): array;
}