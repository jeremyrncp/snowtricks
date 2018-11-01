<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const USER_ADMIN_REFERENCES = "user-admin";

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->getUserBase();

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_ADMIN_REFERENCES, $user);
    }

    /**
     * @return User
     */
    private function getUserBase(): User
    {
        $user = new User();
        $user->setFirstName('Martin');
        $user->setLastName('Durand');
        $user->setEmail('martin.durand@snowtricks.com');
        $user->setDateValidate(new \DateTime());
        $user->setDateCreate(new \DateTime());
        $user->setUserName("Administrator");
        $user->setAvatar(__DIR__ . "..\..\..\public\img\avatar\dc74d0a93e8fc22cc28aed29c3a1057b.png");
        $user->setState(User::USER_EMAIL_VALID);
        $user->setPassword('$2y$10$LwjExTOUm1twstb/H.XRiuhvX8k/hJgtlxUVj1J2Tbad9KtqL/kAS');
        $user->setToken('de932bb7f33882a66ba8e81952c16b6b1ec40095');
        return $user;
    }
}
