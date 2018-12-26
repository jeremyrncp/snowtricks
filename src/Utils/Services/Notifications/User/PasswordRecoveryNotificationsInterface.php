<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services\Notifications\User;

use App\Entity\PasswordRecovery;
use App\Utils\Services\Notifications\NotificationsInterface;

interface PasswordRecoveryNotificationsInterface extends UserNotificationsInterface
{
    public function setPasswordRecovery(PasswordRecovery $passwordRecovery);
}