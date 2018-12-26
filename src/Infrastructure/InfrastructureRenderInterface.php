<?php

/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Infrastructure;

interface InfrastructureRenderInterface
{
    public function renderView(string $view, $params = array()): string;
}