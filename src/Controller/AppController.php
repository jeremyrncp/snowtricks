<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Entity\User;


class AppController extends Controller
{
    public const FLASH_SUCCESS = 'flash_success';
    public const FLASH_ERROR = 'flash_error';

    protected function isValidOwner(User $userLogged, User $ownerEntity)
    {
        if ($userLogged->getId() !== $ownerEntity->getId()) {
            throw new UnauthorizedHttpException("Your aren't owner of this entity");
        }
    }
}
