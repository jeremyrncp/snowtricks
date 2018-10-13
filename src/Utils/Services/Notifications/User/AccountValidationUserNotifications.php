<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 13/10/2018
 * Time: 12:18
 */

namespace App\Utils\Services\Notifications\User;

use App\Exception\UndefinedEntityException;
use App\Infrastructure\InfrastructureMailerInterface;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\InfrastructureValidatorInterface;
use App\Utils\Services\Notifications\NotificationsInterface;

class AccountValidationUserNotifications extends UserNotifications implements NotificationsInterface
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
    }
}
