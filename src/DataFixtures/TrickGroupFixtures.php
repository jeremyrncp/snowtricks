<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\DataFixtures;

use App\Entity\TrickGroup;
use App\Utils\Generic\SlugServices;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class TrickGroupFixtures extends Fixture
{
    public const LIST_TRICK_GROUP = [
        "Les grabs", "Les rotations", "Les flips", "Les rotations désaxées", "Les slides", "Les one foot tricks"
    ];
    public const TRICK_GROUP_REFERENCE_ONE_FOOT_TRICKS = "reference-one-foot-tricks";

    /**
     * @param ObjectManager $manager
     * @throws \App\Exception\EmptyException
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::LIST_TRICK_GROUP as $trick) {
            $trickGroup = new TrickGroup();
            $trickGroup->setName($trick);
            $trickGroup->setSlug(
                SlugServices::slugify($trick)
            );
            $manager->persist($trickGroup);
        }

        $this->addReference(self::TRICK_GROUP_REFERENCE_ONE_FOOT_TRICKS, $trickGroup);
        $manager->flush();
    }
}
