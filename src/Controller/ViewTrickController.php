<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ViewTrickController extends AppController
{
    /**
     * @Route("/trick/{slug}", name="view_trick")
     * @ParamConverter("trick", class="App\Entity\Trick")
     */
    public function index(Trick $trick, Request $request)
    {
        if ($this->getUser()) {
            /** @var Comments $comments */
            $comments = new Comments();
            $commentForm = $this->createForm(CommentsType::class, $comments);

            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $comments->setUser($this->getUser());
                $comments->setTrick($trick);
                $comments->setDateCreate();

                $this->get('doctrine')->getManager()->persist($comments);
                $this->get('doctrine')->getManager()->flush();

                $this->addFlash(self::FLASH_SUCCESS, 'Your comment has correctly added !');
                $comments->setContent("");
            }

            return $this->render('viewtrick.html.twig', [
                'trick' => $trick,
                'formComment' => $commentForm->createView()
            ]);

        }

        return $this->render('viewtrick.html.twig', [
            'trick' => $trick
        ]);
    }
}
