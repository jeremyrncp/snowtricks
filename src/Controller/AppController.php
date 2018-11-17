<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    public const FLASH_SUCCESS = 'flash_success';
    public const FLASH_ERROR = 'flash_error';
}