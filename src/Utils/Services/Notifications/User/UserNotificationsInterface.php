<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 13/10/2018
 * Time: 12:27
 */

namespace App\Utils\Services\Notifications\User;


use App\Entity\User;

interface UserNotificationsInterface
{
    public function setUser(User $user);
}