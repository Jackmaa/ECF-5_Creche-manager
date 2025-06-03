<?php
namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Child $child = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private  ? \DateTime $date = null;

    #[ORM\Column(type : Types::TIME_MUTABLE, nullable: true)]
    private  ? \DateTime $checkInTime = null;

    #[ORM\Column(type : Types::TIME_MUTABLE, nullable: true)]
    private  ? \DateTime $checkOutTime = null;

    #[ORM\ManyToOne]
    private ?User $checkInBy = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable : true)]
    private ?User $checkOutBy = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getChild(): ?Child {
        return $this->child;
    }

    public function setChild(?Child $child): static
    {
        $this->child = $child;

        return $this;
    }

    public function getDate(): ?\DateTime {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCheckInTime(): ?\DateTime {
        return $this->checkInTime;
    }

    public function setCheckInTime( ? \DateTime $checkInTime): static
    {
        $this->checkInTime = $checkInTime;

        return $this;
    }

    public function getCheckOutTime(): ?\DateTime {
        return $this->checkOutTime;
    }

    public function setCheckOutTime( ? \DateTime $checkOutTime): static
    {
        $this->checkOutTime = $checkOutTime;

        return $this;
    }

    public function getCheckInBy(): ?User {
        return $this->checkInBy;
    }

    public function setCheckInBy(?User $checkInBy): static
    {
        $this->checkInBy = $checkInBy;

        return $this;
    }

    public function getCheckOutBy(): ?User {
        return $this->checkOutBy;
    }

    public function setCheckOutBy(?User $checkOutBy): static
    {
        $this->checkOutBy = $checkOutBy;

        return $this;
    }
}
