<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: Concert::class, inversedBy: 'categories')]
    private $concerts;

    #[ORM\ManyToMany(targetEntity: Festival::class, inversedBy: 'categories')]
    private $festivals;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
        $this->festivals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Concert>
     */
    public function getConcert(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): self
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts[] = $concert;
        }

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        $this->concerts->removeElement($concert);

        return $this;
    }

    /**
     * @return Collection<int, Festival>
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    public function addFestival(Festival $festival): self
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals[] = $festival;
        }

        return $this;
    }

    public function removeFestival(Festival $festival): self
    {
        $this->festivals->removeElement($festival);

        return $this;
    }
}
