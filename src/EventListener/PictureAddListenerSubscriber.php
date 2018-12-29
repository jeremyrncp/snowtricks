<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\EventListener;

use App\Entity\Pictures;
use App\Utils\Generic\Files\CopyFilesServicesGeneric;
use App\Utils\Generic\Files\CopyFilesServicesGenericInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureAddListenerSubscriber implements EventSubscriber
{
    /**
     * @var CopyFilesServicesGenericInterface
     */
    private $copyFilesServicesGeneric;

    /**
     * @var string
     */
    private $relativePathToPublic;

    public function __construct(CopyFilesServicesGenericInterface $copyFilesServicesGeneric, string $path, string $relativePathToPublic)
    {
        $copyFilesServicesGeneric->setPathDestination($path);
        $this->copyFilesServicesGeneric = $copyFilesServicesGeneric;
        $this->relativePathToPublic = $relativePathToPublic;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate
        );
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->index($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Pictures && $entity->getPictureRelativePath() instanceof UploadedFile) {
            $imgRealPath = $this->copyFilesServicesGeneric->copyToLocalAfterCheckValidityFile(
                $entity->getPictureRelativePath()
            );
            $imgPath = $this->getImgNameInRealPath($imgRealPath);
            $entity->setPictureRelativePath($this->relativePathToPublic . $imgPath);
        }
    }

    /**
     * @param string $realPath
     * @return string
     * @throws \Exception
     */
    private function getImgNameInRealPath(string $realPath): string
    {
        preg_match('/[a-z0-9]*.(' . implode('|', CopyFilesServicesGeneric::EXTENSION_VALID) . ')$/i', $realPath, $nameImg);

        if (count($nameImg) === 0) {
            throw new \Exception('Your pattern isn\'t found in your path');
        }

        return $nameImg[0];
    }
}
