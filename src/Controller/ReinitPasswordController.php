<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReinitPasswordController extends AbstractController
{
    /**
     * @Route("/reinitpassword/{token]", name="reinit_password")
     */
    public function index()
    {
        return $this->render('reinit_password/index.html.twig', [
            'controller_name' => 'ReinitPasswordController',
        ]);
    }
}
