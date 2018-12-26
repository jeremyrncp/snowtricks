<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Utils\Services\Notifications\User;

use App\Exception\UndefinedEntityException;
use App\Infrastructure\InfrastructureMailerInterface;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\InfrastructureValidatorInterface;
use App\Infrastructure\Mailer\Mailer;

class AccountValidationUserNotifications extends UserNotifications implements UserNotificationsInterface
{

    const SUBJECT_EMAIL = "Account validation";

    /**
     * @var InfrastructureMailerInterface
     */
    private $mailer;

    /**
     * AccountValidationUserNotifications constructor.
     * @param InfrastructureValidatorInterface $validator
     * @param InfrastructureMailerInterface $mailer
     * @param InfrastructureRenderInterface $render
     */
    public function __construct(
        InfrastructureValidatorInterface $validator,
        InfrastructureMailerInterface $mailer,
        InfrastructureRenderInterface $render
    ) {
        parent::__construct($validator, $render);
        $this->mailer = $mailer;
    }

    /**
     * @throws UndefinedEntityException
     */
    public function send()
    {
        $this->isDefinedUser();

        $this->mailer->setSubject(self::SUBJECT_EMAIL);
        $this->mailer->addTo($this->user->getEmail());
        $this->mailer->setSender(Mailer::DEFAULT_REPLYTO_EMAIL);
        $this->mailer->setContent(
            $this->getTemplate(
                "notifications/account-validation.html.twig",
                [
                    "token" => $this->user->getToken(),
                    "subject" => self::SUBJECT_EMAIL
                ]
            )
        );
        $this->mailer->send();
    }
}
