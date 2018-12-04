<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Infrastructure\Mailer\MailerFactory;
use App\Infrastructure\Render\RenderFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Utils\Services\Notifications\User\PasswordRecoveryNotificationsInterface;
use App\Utils\Services\Notifications\User\PasswordRecoveryUserNotifications;
use App\Utils\Services\User\PasswordRecovery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RecoveryPasswordController extends Controller
{

    use SignOutTraitController;

    /**
     * @Route("/forgotpassword", name="forgot_password")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security)
    {
        if ($this->isAuthenticated($security)) {
            return $this->redirectToRoute('index');
        }

        $forgotPassword = $this->createForm(ForgotPasswordType::class);

        $forgotPassword->handleRequest($request);

        if ($forgotPassword->isSubmitted()) {
            $userData = $forgotPassword->getData();

            if (array_key_exists('userName', $userData)) {
                $userRepository = $entityManager->getRepository(User::class);
                $user = $userRepository->findOneBy(['userName' => $userData['userName']]);

                if (null === $user) {
                    $this->addFlash(AppController::FLASH_ERROR, 'Username isn\'t valid');
                } else {
                    $this->sendPasswordRecovery($user);
                    $entityManager->flush();
                    $this->addFlash(AppController::FLASH_SUCCESS, 'A password recovery link was sent, please check your mail box');
                    return $this->redirectToRoute('index');
                }
            }
        }

        return $this->render('forgot-password.html.twig', [
            'form' => $forgotPassword->createView()
        ]);
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    private function sendPasswordRecovery(User $user)
    {
        $passwordRecoveryRepository = $this->getDoctrine()->getRepository(\App\Entity\PasswordRecovery::class);
        $passwordRecovery = new PasswordRecovery(
            $passwordRecoveryRepository,
            $this->getDoctrine()->getManager(),
            $this->getPasswordNotifications()
        );

        $passwordRecovery->sendRecoveryRequest($user);
    }

    /**
     * @return PasswordRecoveryNotificationsInterface
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getPasswordNotifications(): PasswordRecoveryNotificationsInterface
    {
        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory->create();

        $mailerFactory = new MailerFactory($this->container);
        $mailer = $mailerFactory->create();

        $renderFactory = new RenderFactory($this->container);
        $render = $renderFactory->create();

        return new PasswordRecoveryUserNotifications($validator, $mailer, $render);
    }
}
