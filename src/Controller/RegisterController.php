<?php

namespace App\Controller;

use App\Entity\User;
use App\Infrastructure\EntityManager\EntityManagerFactory;
use App\Infrastructure\Mailer\MailerFactory;
use App\Infrastructure\Render\RenderFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Utils\Services\Notifications\User\AccountValidationUserNotifications;
use App\Utils\Services\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request)
    {
        $registerForm = $this->get("form.factory")->create("App\Form\RegisterType");

        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $user = $registerForm->getData();
            $this->registerUser($user);
        }

        return $this->render('register.html.twig', [
                "form" => $registerForm->createView()
            ]
        );
    }

    /**
     * @param User $user
     * @throws \App\Exception\EntityNotValidException
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\ORMException
     * @throws \App\Exception\UndefinedEntityException
     * @throws \App\Exception\UserEmailAlreadyUsedException
     * @throws \App\Exception\UserUserNameAlreadyUsedException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function registerUser(User $user)
    {
        $userServices = new UserServices(
            $this->getDoctrine()->getRepository(User::class),
            $this->getAccountValidationUserNotifications(),
            $this->getEntityManager()
        );

        $userServices->register($user);
    }

    /**
     * @return \App\Infrastructure\InfrastructureEntityManagerInterface
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getEntityManager()
    {
        $entityManagerFactory = new EntityManagerFactory($this->getDoctrine()->getManager());
        return $entityManagerFactory->create();
    }

    /**
     * @return AccountValidationUserNotifications
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getAccountValidationUserNotifications(): AccountValidationUserNotifications
    {
        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory->create();

        $renderFactory = new RenderFactory($this->container);
        $render = $renderFactory->create();

        $mailerFactory = new MailerFactory($this->container);
        $mailer = $mailerFactory->create();

        return new AccountValidationUserNotifications(
            $validator,
            $mailer,
            $render
        );
    }
}
