<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Form\PicturesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class EditPicturesController extends AppController
{
    /**
     * @Route("/pictures/{id}/edit", name="edit_pictures")
     * @ParamConverter("pictures", class="App\Entity\Pictures")
     */
    public function index(Request $request, Pictures $picture, EntityManagerInterface $entityManager)
    {
        $this->isValidOwner($this->getUser(), $picture->getUser());

        $picture->setPictureRelativePath(
            new File($this->getParameter('path.public') . $picture->getPictureRelativePath())
        );

        $pictureForm = $this->createForm(PicturesType::class, $picture);

        $pictureForm->handleRequest($request);
        if ($pictureForm->isSubmitted() && $pictureForm->isValid()) {
            $entityManager->persist($picture);
            $entityManager->flush();

            $this->addFlash(self::FLASH_SUCCESS, 'Picture was correctly updated');
            return $this->redirectToRoute("view_trick", ['slug' => $picture->getTrick()->getSlug()]);
        }

        return $this->render('editmedia.html.twig', [
            'title' => 'Edit picture',
            'picture' => $picture,
            'form' => $pictureForm->createView()
        ]);
    }
}
