<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Validator as AppAsserts;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoviesRepository")
 */
class Movies
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
     * @AppAsserts\YoutubeMovie()
     * @ORM\Column(type="string", length=255)
     */
    private $urlMovie;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateCreate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="Movies")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id")
     */
    private $Trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrlMovie(): ?string
    {
        return $this->urlMovie;
    }

    /**
     * @param string $urlMovie
     */
    public function setUrlMovie(string $urlMovie): void
    {
        $this->urlMovie = $urlMovie;
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
