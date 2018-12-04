<?php

namespace App\Controller;

use App\Entity\PasswordRecovery;
use App\Form\ReinitPasswordType;
use App\Utils\Generic\EncryptionServicesGeneric;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ReinitPasswordController extends AbstractController
{
    use SignOutTraitController;

    /**
     * @Route("/reinitpassword/{token}", options={}, name="reinit_password")
     */
    public function index($token, Request $request, Security $security)
    {
        if ($this->isAuthenticated($security)) {
            return $this->redirectToRoute('index');
        }

        $this->isValidTokenLength($token);

        $passwordRecovery = $this->getDoctrine()
                                 ->getRepository(PasswordRecovery::class)
                                 ->findOneBy(
                                     ['token' => $token]
                                 );

        $this->isValidPasswordRecovery($passwordRecovery, $request->getClientIp());

        $reinitPassword = $this->createForm(ReinitPasswordType::class);
        $reinitPassword->handleRequest($request);

        if (null !== $reinitPassword->getData()) {
            $reinitData = $reinitPassword->getData();

            $this->usedToken($passwordRecovery);

            if ($reinitData['email'] !== $passwordRecovery->getUserRelated()->getEmail()) {
                $this->addFlash(AppController::FLASH_ERROR, 'This email isn\'t valid');

                $this->getDoctrine()->getManager()->persist($passwordRecovery);
                $this->getDoctrine()->getManager()->flush();

                return $this->render('reinit-password.html.twig', [
                    'form' => $reinitPassword->createView()
                ]);
            }

            $this->reinitPassword($reinitData['password'], $passwordRecovery);
            $this->addFlash(AppController::FLASH_SUCCESS, 'Password updated successfully');
            return $this->redirectToRoute('login');
        }

        return $this->render('reinit-password.html.twig', [
            'form' => $reinitPassword->createView()
        ]);
    }

    /**
     * @param PasswordRecovery $passwordRecovery
     */
    private function isValidPasswordRecovery(PasswordRecovery $passwordRecovery, string $ip = null)
    {
        if ($ip !== $passwordRecovery->getIp()) {
            throw new UnauthorizedHttpException('You haven\'t authorization to view this page');
        }
        if (null !== $passwordRecovery->getDateUsed()) {
            throw new UnauthorizedHttpException('Token already used');
        }

        $date = new \DateTime();
        if ($date->getTimestamp() >= $passwordRecovery->getEndDateValidity()->getTimestamp()) {
            throw new UnauthorizedHttpException('Token validity duration is expired');
        }
    }

    /**
     * @param $token
     */
    private function isValidTokenLength($token): void
    {
        if (strlen($token) !== 40) {
            throw new UnauthorizedHttpException("Your token isn't valid");
        }
    }

    /**
     * @param $passwordRecovery
     */
    private function usedToken($passwordRecovery): void
    {
        $passwordRecovery->setDateUsed(new \DateTime());
    }

    /**
     * @param string $clearPassword
     * @param PasswordRecovery $passwordRecovery
     */
    private function reinitPassword(string $clearPassword, PasswordRecovery $passwordRecovery): void
    {
        $passwordReinit = EncryptionServicesGeneric::passwordEncrypt($clearPassword);
        $passwordRecovery->getUserRelated()->setPassword($passwordReinit);
        $this->getDoctrine()->getManager()->persist($passwordRecovery);
        $this->getDoctrine()->getManager()->flush();
    }
}
