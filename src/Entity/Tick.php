<?php

namespace App\Entity;

use App\Repository\TickRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a *stuff* to which a tick is related.
 */
#[ORM\Entity(repositoryClass: TickRepository::class)]
class Tick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTime $time = null;

    #[ORM\ManyToOne(inversedBy: 'ticks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entity $entity = null;

    #[ORM\ManyToOne(inversedBy: 'tick')]
    private ?Unit $unit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getTime(): ?\DateTime
    {
        return $this->time;
    }

    public function setTime(\DateTime $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getEntity(): ?Entity
    {
        return $this->entity;
    }

    public function setEntity(?Entity $entity): static
    {
        $this->entity = $entity;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
}
