<?php

namespace App\Controller\Api;

use App\Utils\Services\Trick\TrickServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiTricksController extends ApiController
{
    /**
     * @Route("/api/ressources/tricks", name="api_tricks")
     *
     **/
    public function index(Request $request, TrickServices $trickServices)
    {
        if ($request->query->has('end') && $request->query->get('end') > TrickServices::LENGTH) {
            $trickCollection = $trickServices->getTricks(TrickServices::START, $request->query->get('end'));
            $length = $request->query->get('end');
        } else {
            $trickCollection = $trickServices->getTricks();
            $length = TrickServices::LENGTH;
        }

        return $this->buildResponseForRessources([
            'trickCollection' => $trickCollection
        ], 'elmt/tricks-list.html.twig');
    }
}
