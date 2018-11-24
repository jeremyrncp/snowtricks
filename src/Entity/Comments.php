<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Asserts;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="text")
     * @Asserts\NotBlank()
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="comments", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Trick;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(): self
    {
        $this->dateCreate = new \DateTime();

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->Trick;
    }

    public function setTrick(?Trick $Trick): self
    {
        $this->Trick = $Trick;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
