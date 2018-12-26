<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Tests\Utils\Generic;

use App\Exception\EmptyException;
use App\Utils\Generic\SlugServices;
use PHPUnit\Framework\TestCase;

class SlugServicesTest extends TestCase
{
    public function testShouldObtainAValidSlug()
    {
        $this->assertEquals("valid-slug", SlugServices::slugify("Valid Slug"));
    }
    public function testShouldObtainAnErrorWhenSlugIsEmpty()
    {
        $this->expectException(EmptyException::class);
        SlugServices::slugify("");
    }
}
