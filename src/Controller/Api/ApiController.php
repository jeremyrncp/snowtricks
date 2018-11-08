<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Controller\Api;

use App\Exception\EmptyException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends AbstractController
{

    /**
     * @param array $data
     * @param string $templateName
     * @return Response
     * @throws EmptyException
     */
    public function buildResponseForRessources(array $data, string $templateName): Response
    {
        if (empty($data)) {
            throw new EmptyException('Data must be not empty');
        }

        $template = $this->renderView($templateName, $data);

        $response = new Response($template, Response::HTTP_OK);
        $response->headers->set('Content', 'text/html');

        return $response;
    }
}
