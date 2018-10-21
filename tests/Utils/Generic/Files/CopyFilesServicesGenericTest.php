<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Utils\Generic\Files;

use App\Exception\FileNotExistException;
use App\Exception\InvalidMimeTypeException;
use App\Exception\PathNotExistException;
use App\Exception\UndefinedParameterException;
use App\Utils\Generic\Files\CopyFilesServicesGeneric;
use PHPUnit\Framework\TestCase;

class CopyFilesServicesGenericTest extends TestCase
{
    public function testShouldObtainAnAValidCopyFile()
    {
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->setPathDestination(__DIR__ . '\FileOut\\');
        $localPathFile = $copyFilesServicesGeneric->copyToLocalAfterCheckValidityFile(
            __DIR__ . '\FileIn\avatar.tmp'
        );

        $fileInfo = new \SplFileInfo($localPathFile);
        $this->assertEquals("png", $fileInfo->getExtension());
    }
    public function testShouldObtainAnErrorWhenMimeTypeIsntAuthorized()
    {
        $this->expectException(InvalidMimeTypeException::class);
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->setPathDestination(__DIR__ . '\FileOut\\');
        $localPathFile = $copyFilesServicesGeneric->copyToLocalAfterCheckValidityFile(
            __DIR__ . '\FileIn\file.empty'
        );
    }
    public function testShouldObtainAnErrorWhenPathDestinationNotExist()
    {
        $this->expectException(PathNotExistException::class);
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->setPathDestination("C:\PHPUNIT\\");
        $copyFilesServicesGeneric->copyToLocalAfterCheckValidityFile(__DIR__ . '\CopyFilesServicesGenericTest.php');
    }
    public function testShouldObtainAnErrorWhenTmpFileIsntExist()
    {
        $this->expectException(FileNotExistException::class);

        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->setPathDestination(__DIR__ . '\FileOut\\');
        $copyFilesServicesGeneric->copyToLocalAfterCheckValidityFile("C:\PHPUNIT\PHP");
    }
    public function testShouldObtainAnErrorWhenPathDestinationIsntDefined()
    {
        $this->expectException(UndefinedParameterException::class);
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->copyToLocalAfterCheckValidityFile("C:\PHPUNIT\PHP");
    }
}
