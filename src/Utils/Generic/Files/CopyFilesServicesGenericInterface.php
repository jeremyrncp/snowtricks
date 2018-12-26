<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Generic\Files;


interface CopyFilesServicesGenericInterface
{
    public function copyToLocalAfterCheckValidityFile(string $tmpFile): string;
    public function setPathDestination(string $pathDestination);
}
