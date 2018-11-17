<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PicturesRepository")
 */
class Pictures
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $pictureRelativePath;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateCreate;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @var Trick
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="Pictures")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     */
    private $Trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureRelativePath(): ?string
    {
        return $this->pictureRelativePath;
    }

    public function setPictureRelativePath(string $pictureRelativePath): self
    {
        $this->pictureRelativePath = $pictureRelativePath;

        return $this;
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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

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
}
