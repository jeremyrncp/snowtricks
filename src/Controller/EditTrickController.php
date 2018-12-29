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

        $actualPicturesRelativePathOrderByIdPicture = $this->getPictureRelativePathById($trick);

        $trick->getPictures()->filter(\Closure::fromCallable(array($this,'updatePicturesCollection')));

        $trickForm = $this->createForm(TrickType::class, $trick);

        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick->setDateUpdate();

            $this->hydratePicturesCollection($trick, $actualPicturesRelativePathOrderByIdPicture);

            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash(self::FLASH_SUCCESS, 'Your trick has correctly edited in our database !');
            return $this->redirectToRoute('index');
        }


        return $this->render('edittrick.html.twig', [
            'form' => $trickForm->createView(),
            'errors' => $trickForm->getData()
        ]);
    }

    private function hydratePicturesCollection(Trick $trick, array $actualPicturesRelativePathOrderByIdPicture)
    {
        /** @var Pictures $picture **/
        foreach ($trick->getPictures() as $picture) {
            if (null === $picture->getPictureRelativePath() && array_key_exists($picture->getId(), $actualPicturesRelativePathOrderByIdPicture)) {
                $picture->setPictureRelativePath($actualPicturesRelativePathOrderByIdPicture[$picture->getId()]);
            }
        }
    }

    /**
     * @param Trick $trick
     * @return array
     *
     */
    private function getPictureRelativePathById(Trick $trick)
    {
        $pictures = [];

        foreach ($this->getDoctrine()->getRepository(Pictures::class)->findBy(['Trick' => $trick]) as $picture) {
            $pictures[$picture->getId()] = $picture->getPictureRelativePath();
        }

        return $pictures;
    }

    public function updatePicturesCollection(Pictures $picture)
    {
        $picture->setPictureRelativePath(
            new File($this->getParameter('path.public') . $picture->getPictureRelativePath())
        );
    }
}
