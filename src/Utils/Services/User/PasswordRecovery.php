<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services\User;

use App\Entity\User;
use App\Exception\UnauthorizedException;
use App\Repository\PasswordRecoveryRepository;
use App\Utils\Services\Notifications\User\PasswordRecoveryNotificationsInterface;
use App\Utils\Utils\GlobalUtils;
use App\Utils\Utils\StringUtils;
use Doctrine\ORM\EntityManagerInterface;

class PasswordRecovery
{

    public const MAX_REQUESTS_BY_24H = 3;
    public const DURATION_VALIDITY_REQUEST_IN_HOURS = 3;

    /**
     * @var PasswordRecoveryRepository
     */
    private $passwordRecoveryRepository;

    /**
     * @var PasswordRecoveryNotificationsInterface
     */
    private $passwordRecoveryNotifications;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PasswordRecovery constructor.
     * @param PasswordRecoveryRepository $passwordRecoveryRepository
     * @param EntityManagerInterface $entityManager
     * @param PasswordRecoveryNotificationsInterface $passwordRecoveryNotifications
     */
    public function __construct(
        PasswordRecoveryRepository $passwordRecoveryRepository,
        EntityManagerInterface $entityManager,
        PasswordRecoveryNotificationsInterface $passwordRecoveryNotifications
    ) {
        $this->passwordRecoveryRepository = $passwordRecoveryRepository;
        $this->em = $entityManager;
        $this->passwordRecoveryNotifications = $passwordRecoveryNotifications;
    }

    /**
     * @param User $user
     * @throws UnauthorizedException
     */
    public function sendRecoveryRequest(User $user)
    {
        $numberRequests = $this->passwordRecoveryRepository->getNumberOfRequestsByUser($user);

        if ($numberRequests >= self::MAX_REQUESTS_BY_24H) {
            throw new UnauthorizedException("You haven't authorized to make this demand");
        }

        $passwordRecovery = $this->createPasswordRecovery($user);
        $this->em->persist($passwordRecovery);

        $this->passwordRecoveryNotifications->setUser($user);
        $this->passwordRecoveryNotifications->setPasswordRecovery($passwordRecovery);
        $this->passwordRecoveryNotifications->send();
    }


    /**
     * @param User $user
     * @return \App\Entity\PasswordRecovery
     * @throws \Exception
     */
    private function createPasswordRecovery(User $user)
    {
        $passwordRecovery = new \App\Entity\PasswordRecovery();
        $passwordRecovery->setDateCreate(new \DateTime());
        $passwordRecovery->setUserRelated($user);
        $passwordRecovery->setEndDateValidity($this->getEndValidity());
        $passwordRecovery->setToken(StringUtils::getToken());
        $passwordRecovery->setIp(GlobalUtils::getIp());

        return $passwordRecovery;
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    private function getEndValidity(): \DateTime
    {
        $dateTime = new \DateTime();
        $dateTime->add(new \DateInterval("PT" . self::DURATION_VALIDITY_REQUEST_IN_HOURS . "H"));

        return $dateTime;
    }
}
