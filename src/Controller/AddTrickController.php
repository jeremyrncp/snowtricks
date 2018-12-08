<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Utils\Generic\SlugServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddTrickController extends AppController
{
    /**
     * @Route("/trick/add", name="add_trick")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $trick = new Trick();
        $trick->setUser($this->getUser());

        $trickForm = $this->createForm(TrickType::class, $trick);

        $trickForm->handleRequest($request);
        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick->setSlug(SlugServices::slugify($trick->getName()));
            $trick->setDateCreate();
            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash(self::FLASH_SUCCESS, 'Your trick has correctly added in our database !');
            return $this->redirectToRoute('index');
        }

        return $this->render('addtrick.html.twig', [
            'form' => $trickForm->createView(),
            'errors' => $trickForm->getData()
        ]);
    }
}
