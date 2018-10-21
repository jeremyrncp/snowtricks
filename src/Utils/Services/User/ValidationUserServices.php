<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services\User;


use App\Exception\UnknownParameterException;
use App\Repository\UserRepository;

class ValidationUserServices
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * ValidationUserServices constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $token
     * @throws UnknownParameterException
     */
    public function validationWithToken(string $token)
    {
        $findUser = $this->userRepository->findOneBy(
            ["token" => $token]
        );

        if (is_null($findUser)) {
            throw new UnknownParameterException(
                sprintf("This token %s isn't valid", $token)
            );
        }
    }
}
