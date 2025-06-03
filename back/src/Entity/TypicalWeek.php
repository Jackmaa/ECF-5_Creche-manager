<?php

namespace App\Entity;

use App\Repository\TypicalWeekRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypicalWeekRepository::class)]
class TypicalWeek
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?child $child = null;

    #[ORM\Column(nullable: true)]
    private ?array $planning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChild(): ?child
    {
        return $this->child;
    }

    public function setChild(?child $child): static
    {
        $this->child = $child;

        return $this;
    }

    public function getPlanning(): ?array
    {
        return $this->planning;
    }

    public function setPlanning(?array $planning): static
    {
        $this->planning = $planning;

        return $this;
    }
}
