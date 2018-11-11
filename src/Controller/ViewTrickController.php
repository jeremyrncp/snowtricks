<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ViewTrickController extends AbstractController
{
    /**
     * @Route("/trick/{slug}", name="view_trick")
     * @ParamConverter("trick", class="App\Entity\Trick")
     */
    public function index(Trick $trick)
    {
        return $this->render('viewtrick.html.twig', [
            'trick' => $trick
        ]);
    }
}
