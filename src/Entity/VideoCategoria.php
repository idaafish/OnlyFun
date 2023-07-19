<?php

namespace App\Entity;

use App\Repository\VideoCategoriaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoCategoriaRepository::class)]
class VideoCategoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?video $video = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?categoria $categoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideo(): ?video
    {
        return $this->video;
    }

    public function setVideo(?video $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getCategoria(): ?categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }
}
