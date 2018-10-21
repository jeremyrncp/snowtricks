<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountValidationController extends AbstractController
{
    /**
     * @Route("/account/validation/{token}", name="account_validation")
     */
    public function index()
    {
        return $this->render('account_validation/index.html.twig', [
            'controller_name' => 'AccountValidationController',
        ]);
    }
}
