<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ViewTrickController extends AppController
{

    const COMMENTS_BY_PAGE = 10;

    /**
     * @Route("/trick/{slug}", name="view_trick")
     * @ParamConverter("trick", class="App\Entity\Trick")
     */
    public function index(Trick $trick, Request $request, EntityManagerInterface $entityManager)
    {
        if ($this->getUser()) {
            return $this->addAndHandleComments($trick, $request, $entityManager);
        }

        return $this->render('viewtrick.html.twig', [
            'trick' => $trick,
            'comments' => $this->getCommentsWithPagination($trick, $request)
        ]);
    }

    /**
     * @param Trick $trick
     * @param Request $request
     * @return PaginationInterface
     */
    private function getCommentsWithPagination(Trick $trick, Request $request): PaginationInterface
    {
        $commentsRepository = $this->getDoctrine()->getRepository(Comments::class);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $commentsRepository->findCommentsByTrick($trick),
            $request->query->getInt('page', 1),
            self::COMMENTS_BY_PAGE
        );
        $pagination->setCustomParameters(array(
            'align' => 'center',
            'size' => 'small',
            'style' => 'bottom',
        ));

        return $pagination;
    }

    /**
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function addAndHandleComments(Trick $trick, Request $request, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        /** @var Comments $comments */
        $comments = new Comments();
        $commentForm = $this->createForm(CommentsType::class, $comments);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comments->setUser($this->getUser());
            $comments->setTrick($trick);
            $comments->setDateCreate();

            $entityManager->persist($comments);
            $entityManager->flush();

            $this->addFlash(self::FLASH_SUCCESS, 'Your comment has correctly added !');

            return $this->redirectToRoute("view_trick", ["slug" => $trick->getSlug()]);
        }

        return $this->render('viewtrick.html.twig', [
            'trick' => $trick,
            'formComment' => $commentForm->createView(),
            'comments' => $this->getCommentsWithPagination($trick, $request)
        ]);
    }
}
