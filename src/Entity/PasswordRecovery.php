<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PasswordRecoveryRepository")
 */
class PasswordRecovery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDateValidity;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateUsed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_related_id", referencedColumnName="id")
     */
    private $userRelated;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $ip;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateUsed(): ?\DateTimeInterface
    {
        return $this->dateUsed;
    }

    public function setDateUsed(\DateTimeInterface $dateUsed): self
    {
        $this->dateUsed = $dateUsed;

        return $this;
    }

    public function getEndDateValidity(): ?\DateTimeInterface
    {
        return $this->endDateValidity;
    }

    public function setEndDateValidity(\DateTimeInterface $endDateValidity): self
    {
        $this->endDateValidity = $endDateValidity;

        return $this;
    }
    /**
     * @return User
     */
    public function getUserRelated()
    {
        return $this->userRelated;
    }

    /**
     * @param mixed $userRelated
     */
    public function setUserRelated($userRelated): void
    {
        $this->userRelated = $userRelated;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }
}
