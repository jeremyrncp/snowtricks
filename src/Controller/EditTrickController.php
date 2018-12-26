<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Entity\Trick;
use App\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class EditTrickController extends AppController
{
    /**
     * @Route("/trick/{slug}/edit", name="edit_trick")
     * @ParamConverter("trick", class="App\Entity\Trick")
     */
    public function index(Request $request, Trick $trick, EntityManagerInterface $entityManager)
    {
        $this->isValidOwner($this->getUser(), $trick->getUser());

        $trick->getPictures()->filter(\Closure::fromCallable(array($this,'updatePicturesCollection')));

        $trickForm = $this->createForm(TrickType::class, $trick);

        $trickForm->handleRequest($request);
        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick->setDateUpdate();
            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash(self::FLASH_SUCCESS, 'Your trick has correctly added in our database !');
            return $this->redirectToRoute('index');
        }

        return $this->render('edittrick.html.twig', [
            'form' => $trickForm->createView(),
            'errors' => $trickForm->getData()
        ]);
    }

    public function updatePicturesCollection(Pictures $picture)
    {
        $picture->setPictureRelativePath(
            new File($this->getParameter('path.public') . $picture->getPictureRelativePath())
        );
    }
}
