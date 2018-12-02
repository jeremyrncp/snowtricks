<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Utils\Services\Notifications\User;


use App\Entity\User;
use App\Utils\Services\Notifications\NotificationsInterface;

interface UserNotificationsInterface extends NotificationsInterface
{
    public function setUser(User $user);
}