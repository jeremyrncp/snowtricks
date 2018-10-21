<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services\User;

use App\Entity\User;
use App\Exception\TokenAlreadyUsedException;
use App\Exception\UnknownParameterException;
use App\Infrastructure\InfrastructureEntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class ValidationUserServices
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var InfrastructureEntityManagerInterface
     */
    private $entityManager;

    /**
     * ValidationUserServices constructor.
     * @param UserRepository $userRepository
     * @param InfrastructureEntityManagerInterface $entityManager
     */
    public function __construct(
        UserRepository $userRepository,
        InfrastructureEntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $token
     * @throws TokenAlreadyUsedException
     * @throws UnknownParameterException
     */
    public function validationWithToken(string $token)
    {
        $this->isValidToken($token);

        $user = $this->userRepository->findOneBy(
            ["token" => $token]
        );

        $this->isKnownToken($token, $user);
        $this->isUsableToken($token, $user);

        $user->setState(User::USER_EMAIL_VALID);
        $user->setDateValidate(new \DateTime());

        $this->entityManager->flush();
    }

    /**
     * @param string $token
     * @param $user
     * @throws UnknownParameterException
     */
    private function isKnownToken(string $token, $user): void
    {
        if (is_null($user)) {
            throw new UnknownParameterException(
                sprintf("This token %s isn't valid", $token)
            );
        }
    }

    /**
     * @param string $token
     */
    private function isValidToken(string $token): void
    {
        if (strlen($token) !== 40) {
            throw new InvalidParameterException("Token must be contain 40 characters");
        }
    }

    /**
     * @param string $token
     * @param $user
     * @throws TokenAlreadyUsedException
     */
    private function isUsableToken(string $token, $user): void
    {
        if ($user->getState() !== User::USER_EMAIL_INVALID) {
            throw new TokenAlreadyUsedException(
                sprintf("Your token %s as already used", $token)
            );
        }
    }
}
