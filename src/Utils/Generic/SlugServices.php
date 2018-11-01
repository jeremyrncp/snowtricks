<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Generic;

use App\Exception\EmptyException;
use Cocur\Slugify\Slugify;

class SlugServices
{
    /**
     * @param string $slug
     * @return string
     * @throws EmptyException
     */
    public static function slugify(string $slug)
    {
        if (empty($slug)) {
            throw new EmptyException("Slug must be not empty");
        }

        $slugify = new Slugify();
        return $slugify->slugify($slug); // hello-world
    }
}
