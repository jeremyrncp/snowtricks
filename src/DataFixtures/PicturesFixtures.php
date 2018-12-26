<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\DataFixtures;

use App\Entity\Pictures;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PicturesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->addDefaultPicture($manager);

        foreach ($manager->getRepository(Trick::class)->findAll() as $trick) {
            $pictures = $this->getPictureWithTrick($trick);
            $manager->persist($pictures);
        }

        $manager->flush();
    }

    private function getPictureWithTrick(Trick $trick): Pictures
    {
        $pictures = new Pictures();
        $pictures->setUser($this->getAdminUser());
        $pictures->setDateCreate(new \DateTime());
        $pictures->setTrick($trick);
        $pictures->setPictureRelativePath('img/tricks/example-lg.jpg');
        return $pictures;
    }

    /**
     * @return User
     */
    private function getAdminUser(): User
    {
        return $this->getReference(UserFixtures::USER_ADMIN_REFERENCES);
    }

    /**
     * @param ObjectManager $manager
     */
    private function addDefaultPicture(ObjectManager $manager)
    {
        $picture = new Pictures();
        $picture->setDateCreate(new \DateTime());
        $picture->setUser($this->getAdminUser());
        $picture->setPictureRelativePath('img/tricks/default.png');

        $manager->persist($picture);
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            TrickGroupFixtures::class,
            UserFixtures::class,
            TrickFixtures::class
        ];
    }
}