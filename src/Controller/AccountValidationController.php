<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\TokenAlreadyUsedException;
use App\Infrastructure\EntityManager\EntityManagerFactory;
use App\Utils\Services\User\ValidationUserServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountValidationController extends AbstractController
{
    /**
     * @Route("/account/validation/{token}", name="account_validation")
     */
    public function index($token)
    {
        try {
            $this->validateAccountWithToken($token);

            $params = ["msg" => "accountValidationSuccess"];
        } catch (\Exception $e) {
            if ($e instanceof TokenAlreadyUsedException) {
                $this->redirectToRoute("login");
            }

            $params = ["error" => $e->getMessage()];
        }

        return $this->render('accountvalidation.html.twig', $params);
    }

    /**
     * @param string $token
     * @throws TokenAlreadyUsedException
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\UnknownParameterException
     */
    private function validateAccountWithToken(string $token): void
    {
        $entityManagerFactory = new EntityManagerFactory($this->getDoctrine()->getManager());
        $entityManager = $entityManagerFactory->create();

        $validationUserServices = new ValidationUserServices(
            $this->getDoctrine()->getRepository(User::class),
            $entityManager
        );
        $validationUserServices->validationWithToken($token);
    }
}
