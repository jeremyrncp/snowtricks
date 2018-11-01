<?php

namespace App\Entity;

use App\Exception\NotFoundPictureException;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var Pictures
     * @ORM\OneToMany(targetEntity="App\Entity\Pictures", mappedBy="Trick")
     */
    private $Pictures;

    public function __construct()
    {
        $this->Pictures = new ArrayCollection();
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
     * @return Pictures
     */
    public function getPictures()
    {
        return $this->Pictures;
    }

    /**
     * @return Pictures|null
     * @throws NotFoundPictureException
     */
    public function getPicturePresentation(): ?Pictures
    {
        if (count($this->Pictures) === 0) {
            throw new NotFoundPictureException(
                sprintf('This trick have zero picture !')
            );
        }

        return current($this->Pictures->toArray());
    }
}
