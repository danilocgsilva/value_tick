<?php

namespace App\Entity;

use App\Repository\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityRepository::class)]
class Entity
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
    #[ORM\OneToMany(targetEntity: Tick::class, mappedBy: 'entity')]
    private Collection $ticks;

    public function __construct()
    {
        $this->ticks = new ArrayCollection();
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
    public function getTicks(): Collection
    {
        return $this->ticks;
    }

    public function addTick(Tick $tick): static
    {
        if (!$this->ticks->contains($tick)) {
            $this->ticks->add($tick);
            $tick->setEntity($this);
        }

        return $this;
    }

    public function removeTick(Tick $tick): static
    {
        if ($this->ticks->removeElement($tick)) {
            // set the owning side to null (unless already changed)
            if ($tick->getEntity() === $this) {
                $tick->setEntity(null);
            }
        }

        return $this;
    }
}
