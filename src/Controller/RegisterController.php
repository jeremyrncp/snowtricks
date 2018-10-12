<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index()
    {
        $registerForm = $this->get("form.factory")->create("App\Form\RegisterType");

        return $this->render('register.html.twig', [
            "form" => $registerForm->createView()
            ]
        );
    }
}
