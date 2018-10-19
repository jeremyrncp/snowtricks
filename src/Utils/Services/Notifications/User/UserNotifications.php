<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Utils\Services\Notifications\User;


use App\Entity\User;
use App\Exception\EntityNotValidException;
use App\Exception\UndefinedEntityException;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\InfrastructureValidatorInterface;

class UserNotifications implements UserNotificationsInterface
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var InfrastructureValidatorInterface
     */
    private $validator;

    /**
     * @var InfrastructureRenderInterface
     */
    private $render;

    /**
     * UserNotifications constructor.
     * @param InfrastructureValidatorInterface $validator
     * @param InfrastructureRenderInterface $render
     */
    public function __construct(
        InfrastructureValidatorInterface $validator,
        InfrastructureRenderInterface $render
    ) {
        $this->validator = $validator;
        $this->render = $render;
    }

    /**
     * @param User $user
     * @throws EntityNotValidException
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        if (!$this->validator->validate($user)) {
            throw new EntityNotValidException("Entity isn't valid : " . implode(',', $this->validator->getErrors()));
        }
    }

    /**
     * @throws UndefinedEntityException
     */
    protected function isDefinedUser(): void
    {
        if (empty($this->user)) {
            throw new UndefinedEntityException("User must be defined before send notification");
        }
    }

    /**
     * @param string $nameTemplate
     * @param array $params
     * @return string
     */
    protected function getTemplate(string $nameTemplate, array $params): string
    {
        return $this->render->renderView($nameTemplate, $params);
    }
}
