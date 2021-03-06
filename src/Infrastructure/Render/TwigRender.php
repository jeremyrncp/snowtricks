<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Infrastructure\Render;

use App\Exception\ViewNotFoundException;
use App\Exception\ViewParamsUndefinedException;
use App\Exception\ViewSyntaxErrorException;
use App\Infrastructure\InfrastructureRenderInterface;

class TwigRender implements InfrastructureRenderInterface
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * TwigRender constructor.
     * @param \Twig_Environment $twigEngine
     */
    public function __construct(\Twig_Environment $twigEngine)
    {
        $this -> twig = $twigEngine;
    }


    /**
     * @param string $view
     * @param array $params
     * @return string
     * @throws ViewNotFoundException
     * @throws ViewParamsUndefinedException
     * @throws ViewSyntaxErrorException
     */
    public function renderView(string $view, $params = array()): string
    {
        try {
            $render = $this->twig->render($view, $params);
            return $render;
        } catch (\Twig_Error_Loader $e) {
            throw new ViewNotFoundException("This view ins't found : " . $e -> getMessage());
        } catch (\Twig_Error_Runtime $e) {
            throw new ViewParamsUndefinedException("Error occurred during render : " . $e -> getMessage());
        } catch (\Twig_Error_Syntax $e) {
            throw new ViewSyntaxErrorException("Error in syntax : " . $e -> getMessage());
        }
    }

}