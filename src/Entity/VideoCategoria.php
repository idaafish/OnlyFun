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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?video $videoId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?categoria $categoriaId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoId(): ?video
    {
        return $this->videoId;
    }

    public function setVideoId(video $videoId): static
    {
        $this->videoId = $videoId;

        return $this;
    }

    public function getCategoriaId(): ?categoria
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(categoria $categoriaId): static
    {
        $this->categoriaId = $categoriaId;

        return $this;
    }
}
