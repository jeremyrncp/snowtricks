<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Infrastructure\Render;

use App\Exception\InfrastructureAdapterException;
use App\Infrastructure\InfrastructureRenderInterface;
use Psr\Container\ContainerInterface;

class RenderFactory
{
    const RENDERS = ['Twig'];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * RenderFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this -> container = $container;
    }

    /**
     * @param string $name
     * @return TwigRender
     * @throws InfrastructureAdapterException
     */
    public function create(string $name = "Twig")
    {
        $this->isValidRenderException($name);
        return $this -> getTwigRender();
    }

    /**
     * @param string $name
     * @throws InfrastructureAdapterException
     */
    private function isValidRenderException(string $name): void
    {
        if (!in_array($name, self::RENDERS)) {
            throw new InfrastructureAdapterException(
                "The render " . $name . " isn't valid, the render must be in this list : " . implode(",", self::RENDERS)
            );
        }
    }

    /**
     * @return InfrastructureRenderInterface
     */
    private function getTwigRender()
    {
        return new TwigRender($this -> container -> get("twig"));
    }
}