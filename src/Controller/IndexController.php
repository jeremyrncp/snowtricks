<?php

namespace App\Controller;

use App\Utils\Services\Trick\TrickServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(TrickServices $trickServices)
    {
        return $this->render('index.html.twig', [
                'trickCollection' => $trickServices->getTricks(),
                'length' => TrickServices::LENGTH
        ]);
    }
}
