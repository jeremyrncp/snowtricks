<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\MoviesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class EditMoviesController extends AppController
{
    /**
     * @Route("/movies/{id}/edit", name="edit_movies")
     * @ParamConverter("movie", class="App\Entity\Movies")
     */
    public function index(Request $request, Movies $movie)
    {
        $this->isValidOwner($this->getUser(), $movie->getUser());

        $movieForm = $this->createForm(MoviesType::class, $movie);

        $movieForm->handleRequest($request);
        if ($movieForm->isSubmitted() && $movieForm->isValid()) {
            $this->get('doctrine')->getManager()->persist($movie);
            $this->get('doctrine')->getManager()->flush();

            $this->addFlash(self::FLASH_SUCCESS, 'Movie was correctly updated');
            return $this->redirectToRoute("view_trick", ['slug' => $movie->getTrick()->getSlug()]);
        }

        return $this->render('editmedia.html.twig', [
            'title' => 'Edit movie',
            'form' => $movieForm->createView()
        ]);
    }
}
