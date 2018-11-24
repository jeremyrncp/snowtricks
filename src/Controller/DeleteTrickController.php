<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DeleteTrickController extends AppController
{
    /**
     * @Route("/trick/{slug}/delete", name="delete_trick")
     * @ParamConverter("trick", class="App\Entity\Trick")
     */
    public function index(Request $request, Trick $trick)
    {
        $this->isValidOwner($this->getUser(), $trick->getUser());

        $this->get('doctrine')->getManager()->remove($trick);
        $this->get('doctrine')->getManager()->flush();

        $this->addFlash(AppController::FLASH_SUCCESS, 'Trick successfully deleted !');

        return $this->redirectToRoute('index');
    }
}
