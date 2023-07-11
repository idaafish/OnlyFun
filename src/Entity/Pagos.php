<?php

namespace App\Entity;

use App\Repository\PagosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagosRepository::class)]
class Pagos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $mes = null;

    #[ORM\ManyToOne(inversedBy: 'pagosId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMes(): ?\DateTimeInterface
    {
        return $this->mes;
    }

    public function setMes(\DateTimeInterface $mes): static
    {
        $this->mes = $mes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
