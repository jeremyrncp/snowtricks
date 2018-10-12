<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Asserts;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    const USER_DISABLED = 2;
    const USER_EMAIL_VALID = 1;
    const USER_EMAIL_INVALID = 0;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Asserts\NotBlank()
     * @Asserts\Type(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Asserts\NotBlank()
     * @Asserts\Type(type="string")
     */
    private $lastName;

    /**
     * @ORM\Column(type="text")
     * @Asserts\NotBlank()
     * @Asserts\Type(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=200, unique=true)
     * @Asserts\NotBlank()
     * @Asserts\
     * @Asserts\Type(type="string")
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=200, unique=true)
     * @Asserts\NotBlank()
     * @Asserts\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $state = self::USER_EMAIL_INVALID;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     * @Asserts\DateTime()
     */
    private $dateCreate;


    /**
     * @ORM\Column(type="blob")
     * @Asserts\Image(
     * mimeTypes="image/png, image/jpeg"), maxHeight="500", minHeight="500"
     * )
     */
    private $avatar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateValidate;

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param $avatar
     * @return User
     */
    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDateValidate(): ?\DateTimeInterface
    {
        return $this->dateValidate;
    }

    public function setDateValidate(?\DateTimeInterface $dateValidate): self
    {
        $this->dateValidate = $dateValidate;

        return $this;
    }
}
