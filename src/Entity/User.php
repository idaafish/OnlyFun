<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nombre = null;

    #[ORM\Column(length: 150)]
    private ?string $usuario = null;

    #[ORM\Column(length: 150)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Pagos::class, orphanRemoval: true)]
    private Collection $pagosId;

    public function __construct()
    {
        $this->pagosId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return Collection<int, Pagos>
     */
    public function getPagosId(): Collection
    {
        return $this->pagosId;
    }

    public function addPagosId(Pagos $pagosId): static
    {
        if (!$this->pagosId->contains($pagosId)) {
            $this->pagosId->add($pagosId);
            $pagosId->setUser($this);
        }

        return $this;
    }

    public function removePagosId(Pagos $pagosId): static
    {
        if ($this->pagosId->removeElement($pagosId)) {
            // set the owning side to null (unless already changed)
            if ($pagosId->getUser() === $this) {
                $pagosId->setUser(null);
            }
        }

        return $this;
    }
}
