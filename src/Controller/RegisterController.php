<?php

namespace App\Controller;

use App\Entity\User;
use App\Infrastructure\EntityManager\EntityManagerFactory;
use App\Infrastructure\Mailer\MailerFactory;
use App\Infrastructure\Render\RenderFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Utils\Generic\Files\CopyFilesServicesGeneric;
use App\Utils\Generic\Files\CopyFilesServicesGenericInterface;
use App\Utils\Services\Notifications\User\AccountValidationUserNotifications;
use App\Utils\Services\User\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends Controller
{
    /**
     * @var CopyFilesServicesGenericInterface
     */
    private $copyFilesServicesGeneric;

    /**
     * @Route("/register", name="register")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $registerForm = $this->get("form.factory")->create("App\Form\RegisterType");

        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $user = $registerForm->getData();
            return $this->logicRenderToRegisterUser($user, $registerForm);
        }

        return $this->render(
            'register.html.twig',
            [
                "form" => $registerForm->createView()
            ]
        );
    }


    /**
     * @param $user
     * @param $registerForm
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function logicRenderToRegisterUser($user, $registerForm): \Symfony\Component\HttpFoundation\Response
    {
        try {
            $this->registerUser($user);
            $paramsRender = array("msg" => "registerSuccess");
        } catch (\Exception $e) {
            $paramsRender = array("error" => $e->getMessage(),
                    "form" => $registerForm->createView()
            );
        }

        return $this->render(
            'register.html.twig',
            $paramsRender
        );
    }

    /**
     * @param User $user
     * @throws \App\Exception\CopyException
     * @throws \App\Exception\EntityNotValidException
     * @throws \App\Exception\FileNotExistException
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\InvalidMimeTypeException
     * @throws \App\Exception\ORMException
     * @throws \App\Exception\PathNotExistException
     * @throws \App\Exception\UndefinedEntityException
     * @throws \App\Exception\UserEmailAlreadyUsedException
     * @throws \App\Exception\UserUserNameAlreadyUsedException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function registerUser(User $user)
    {
        $copyFilesServicesGeneric = new CopyFilesServicesGeneric();
        $copyFilesServicesGeneric->setPathDestination(
            $this->getParameter("path")["avatar"]
        );

        $userServices = new UserServices(
            $this->getDoctrine()->getRepository(User::class),
            $this->getAccountValidationUserNotifications(),
            $this->getEntityManager(),
            $copyFilesServicesGeneric
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
