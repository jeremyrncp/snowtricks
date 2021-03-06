<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Asserts;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirements;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    const USER_DISABLED = 2;
    const USER_EMAIL_VALID = 1;
    const USER_EMAIL_INVALID = 0;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     * @Asserts\NotBlank()
     * @Asserts\Type(type="string")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     * @Asserts\NotBlank()
     * @Asserts\Type(type="string")
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Asserts\NotBlank()
     * @Asserts\Type(type="string")
     * @PasswordRequirements(
     *  requireLetters=true,
     *  requireNumbers=true,
     *  requireSpecialCharacter=true,
     *  minLength=8
     *  )
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, unique=true)
     * @Asserts\NotBlank()
     * @Asserts\Type(type="string")
     * @Asserts\Regex(
     *     pattern="/^([A-Za-z]*)$/",
     *     match=true,
     *     message="Your username must contain letters but not contain digit or other caracter"
     * )
     */
    private $userName;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, unique=true)
     * @Asserts\NotBlank()
     * @Asserts\Email()
     */
    private $email;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $state = self::USER_EMAIL_INVALID;

    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     * @Asserts\Type(type="string")
     */
    private $token;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Asserts\DateTime()
     */
    private $dateCreate;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Asserts\Image(
     *     mimeTypes={"image/png", "image/jp2", "image/jpm", "image/jpx"},
     *     maxHeight="500",
     *     maxWidth="500"
     * )
     */
    private $avatar;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateValidate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="User")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

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


    public function setId(int $id)
    {
        $this->id = $id;
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

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function __toString(): string
    {
        return $this->userName;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Comments $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setUser($this);
        }

        return $this;
    }

    public function removeUser(Comments $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUser() === $this) {
                $user->setUser(null);
            }
        }

        return $this;
    }
}
