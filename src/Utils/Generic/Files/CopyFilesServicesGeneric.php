<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Generic\Files;


use App\Exception\CopyException;
use App\Exception\FileNotExistException;
use App\Exception\InvalidMimeTypeException;
use App\Exception\PathNotExistException;
use App\Exception\UndefinedParameterException;

class CopyFilesServicesGeneric implements CopyFilesServicesGenericInterface
{
    const MIME_TYPE_VALID = ["image/jpg", "image/jpeg", "image/png"];
    const EXTENSION_VALID = ['jpg', 'jpeg', 'png'];

    /**
     * @var string
     */
    private $pathDestination;


    /**
     * @param string $pathDestination
     * @throws PathNotExistException
     */
    public function setPathDestination(string $pathDestination)
    {
        $this->isValidDestinationPath($pathDestination);
        $this->pathDestination = $pathDestination;
    }

    /**
     * @param string $tmpFilePath
     * @param string $pathDestination
     * @return string
     * @throws CopyException
     * @throws FileNotExistException
     * @throws InvalidMimeTypeException
     * @throws PathNotExistException
     */
    public function copyToLocalAfterCheckValidityFile(string $tmpFilePath): string
    {
        if (!isset($this->pathDestination)) {
            throw new UndefinedParameterException("pathDefinition must be defined");
        }

        $this->isTmpFileExist($tmpFilePath);

        $finfo = new \finfo();
        $this->isValidMimeType($tmpFilePath, $finfo);

        return $this->defineNameFileAndCopy($tmpFilePath, $this->pathDestination, $finfo);
    }

    /**
     * @param string $tmpFilePath
     * @throws FileNotExistException
     */
    private function isTmpFileExist(string $tmpFilePath): void
    {
        if (!file_exists($tmpFilePath)) {
            throw new FileNotExistException(
                sprintf("Tmp file %s isn't exist", $tmpFilePath)
            );
        }
    }

    /**
     * @param string $pathDestination
     * @throws PathNotExistException
     */
    private function isValidDestinationPath(string $pathDestination): void
    {
        if (!is_dir($pathDestination)) {
            throw new PathNotExistException(
                sprintf("Your path %s isn't exist", $pathDestination)
            );
        }
    }

    /**
     * @param string $tmpFilePath
     * @param \finfo $finfo
     * @throws InvalidMimeTypeException
     */
    private function isValidMimeType(string $tmpFilePath, \finfo $finfo): void
    {
        if (!in_array($finfo->file($tmpFilePath, FILEINFO_MIME_TYPE), self::MIME_TYPE_VALID)) {
            throw new InvalidMimeTypeException(
                "File must be in this authorized mime type list : " . implode(',', self::MIME_TYPE_VALID)
            );
        }
    }

    /**
     * @param string $tmpFilePath
     * @param string $pathDestination
     * @param $finfo
     * @return string
     * @throws CopyException
     */
    private function defineNameFileAndCopy(string $tmpFilePath, string $pathDestination, $finfo): string
    {
        preg_match("/([a-z]*)\/([a-z]*)/", $finfo->file($tmpFilePath, FILEINFO_MIME), $mimeInformations);

        $tmpFileInformations = new \SplFileInfo($tmpFilePath);
        $fileName = md5($tmpFileInformations->getBasename() . rand());
        $fileDestinationPath = $pathDestination . $fileName . "." . $mimeInformations[2];

        $this->copyFile($tmpFilePath, $fileDestinationPath);

        return $fileDestinationPath;
    }

    /**
     * @param string $tmpFilePath
     * @param $fileDestinationPath
     * @throws CopyException
     */
    private function copyFile(string $tmpFilePath, $fileDestinationPath): void
    {
        if (!copy($tmpFilePath, $fileDestinationPath)) {
            throw new CopyException(
                sprintf("Error during copy file in destination path : %s", $fileDestinationPath)
            );
        }
    }
}
