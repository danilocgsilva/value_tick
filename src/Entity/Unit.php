<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Tick>
     */
    #[ORM\OneToMany(targetEntity: Tick::class, mappedBy: 'unit')]
    private Collection $tick;

    public function __construct()
    {
        $this->tick = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Tick>
     */
    public function getTick(): Collection
    {
        return $this->tick;
    }

    public function addTick(Tick $tick): static
    {
        if (!$this->tick->contains($tick)) {
            $this->tick->add($tick);
            $tick->setUnit($this);
        }

        return $this;
    }

    public function removeTick(Tick $tick): static
    {
        if ($this->tick->removeElement($tick)) {
            // set the owning side to null (unless already changed)
            if ($tick->getUnit() === $this) {
                $tick->setUnit(null);
            }
        }

        return $this;
    }
}
