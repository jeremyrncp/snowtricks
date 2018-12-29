<?php

namespace App\Entity;

use App\Exception\NotFoundPictureException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
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
     * @ORM\Column(type="string", length=200)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="string", length=200)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateUpdate;

    /**
     * @var TrickGroup
     * @ORM\ManyToOne(targetEntity="App\Entity\TrickGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TrickGroup;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @var Pictures[]
     * @ORM\OneToMany(targetEntity="App\Entity\Pictures", mappedBy="Trick", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $Pictures;

    /**
     * @var Movies[]
     * @ORM\OneToMany(targetEntity="App\Entity\Movies", mappedBy="Trick", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $Movies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="Trick")
     */
    private $comments;

    public function __construct()
    {
        $this->Pictures = new ArrayCollection();
        $this->Movies = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->TrickGroup;
    }

    public function setTrickGroup(?TrickGroup $TrickGroup): self
    {
        $this->TrickGroup = $TrickGroup;

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

    /**
     * @return ArrayCollection
     */
    public function getPictures()
    {
        return $this->Pictures;
    }

    public function addPicture(Pictures $picture)
    {
        $picture->setTrick($this);
        $picture->setDateCreate();
        $picture->setUser($this->getUser());
        $this->Pictures->add($picture);
    }

    public function removePicture($picture)
    {
        $this->Pictures->removeElement($picture);
    }

    /**
     * @return Pictures|null
     */
    public function getPicturePresentation(): ?Pictures
    {
        if (count($this->Pictures) === 0) {
            return null;
        }

        return current($this->Pictures->toArray());
    }

    /**
     * @return ArrayCollection
     */
    public function getMovies()
    {
        return $this->Movies;
    }

    public function addMovie(Movies $movie)
    {
        $movie->setTrick($this);
        $movie->setDateCreate();
        $movie->setUser($this->getUser());
        $this->Movies->add($movie);
    }

    public function removeMovie($movie)
    {
        $this->Movies->removeElement($movie);
    }

    /**
     * @return \DateTime
     */
    public function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }

    public function setDateCreate(): void
    {
        $this->dateCreate = new \DateTime();
    }

    /**
     * @return \DateTime|null
     */
    public function getDateUpdate(): ?\DateTime
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(): void
    {
        $this->dateUpdate = new \DateTime();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }
}
