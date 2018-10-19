<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Utils\Services\Notifications\User;


use App\Entity\User;

interface UserNotificationsInterface
{
    public function setUser(User $user);
}