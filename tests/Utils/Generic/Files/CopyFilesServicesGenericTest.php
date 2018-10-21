<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Utils\Generic\Files;

use App\Exception\FileNotExistException;
use App\Exception\InvalidMimeTypeException;
use App\Exception\PathNotExistException;
use App\Utils\Generic\Files\CopyFilesServicesGeneric;
use PHPUnit\Framework\TestCase;

class CopyFilesServicesGenericTest extends TestCase
{
    public function testShouldObtainAnAValidCopyFile()
    {
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $localPathFile = $copyFilesServicesGeneric->copyToLocalAfterValidityFile(
            __DIR__ . '\FileIn\avatar.tmp',
            __DIR__ . '\FileOut\\'
        );

        $fileInfo = new \SplFileInfo($localPathFile);
        $this->assertEquals("png", $fileInfo->getExtension());
    }
    public function testShouldObtainAnErrorWhenMimeTypeIsntAuthorized()
    {
        $this->expectException(InvalidMimeTypeException::class);
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $localPathFile = $copyFilesServicesGeneric->copyToLocalAfterValidityFile(
            __DIR__ . '\FileIn\file.empty',
            __DIR__ . '\FileOut\\'
        );
    }
    public function testShouldObtainAnErrorWhenPathDestinationNotExist()
    {
        $this->expectException(PathNotExistException::class);
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->copyToLocalAfterValidityFile(__DIR__ . '\CopyFilesServicesGenericTest.php', "C:\PHPUNIT\\");
    }
    public function testShouldObtainAnErrorWhenTmpFileIsntExist()
    {
        $this->expectException(FileNotExistException::class);

        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->copyToLocalAfterValidityFile("C:\PHPUNIT\PHP", "C:\PHPUNIT\\");
    }
}
