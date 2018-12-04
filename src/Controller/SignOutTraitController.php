<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Controller;


use Symfony\Component\Security\Core\Security;

trait SignOutTraitController
{
    public function isAuthenticated(Security $security)
    {
        if ($security->getToken()->isAuthenticated() && count($security->getToken()->getRoles()) > 0) {
            $this->addFlash(AppController::FLASH_ERROR, 'Please sign out');
            return true;
        }
    }
}