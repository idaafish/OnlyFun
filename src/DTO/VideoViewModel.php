<?php

namespace App\DTO;

use App\Entity\Video;
use App\Entity\VideoCategoria;
use App\Entity\VideoUser;
use App\Entity\Categoria;
use App\Entity\User;

class VideoViewModel
{
    private ?string $id;
    private ?string $nombre;
    private ?string $url;
    private ?string $descripcion;
    private ?string $categoriaNombre;
    private ?string $userId;

    public function __construct(
        ?string $id,
        ?string $nombre,
        ?string $url,
        ?string $descripcion,
        ?string $categoriaNombre,
        ?string $userId
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->url = $url;
        $this->descripcion = $descripcion;
        $this->categoriaNombre = $categoriaNombre;
        $this->userId = $userId;
    }

    public static function fromVideoAndVideoUser(Video $video, VideoUser $videoUser): self
    {
        $viewModel = new self(
            $video->getId(),
            $video->getNombre(),
            $video->getUrl(),
            $video->getDescripcion(),
            null,
            $videoUser->getUser()->getId()
        );

        return $viewModel;
    }

    public static function fromVideoAndVideoCategoria(Video $video, VideoCategoria $videoCategoria): self
    {
        $viewModel = new self(
            $video->getId(),
            $video->getNombre(),
            $video->getUrl(),
            $video->getDescripcion(),
            $videoCategoria->getCategoria()->getNombre(),
            null
        );

        return $viewModel;
    }

    /**
     * Transforma la entidad Video en un objeto VideoViewModel.
     *
     * @return VideoViewModel
     */
    public function toVideoViewModel(): VideoViewModel
    {
        // Luego, puedes crear el objeto VideoViewModel con los datos necesarios.
        $videoViewModel = new VideoViewModel(
            $this->getId(),
            $this->getNombre(),
            $this->getUrl(),
            $this->getDescripcion(),
            null, // $categoriaNombre (si se obtiene de la relación con Categorias)
            null  // $userId (si se obtiene de la relación con Usuarios)
        );

        return $videoViewModel;
    }

     /**
     * Transforma el objeto VideoViewModel en una instancia de la entidad Video.
     *
     * @return Video
     */
    public function toVideoEntity(): Video
    {
        $video = new Video();
        $video->setNombre($this->getNombre());
        $video->setUrl($this->getUrl());
        $video->setDescripcion($this->getDescripcion());

        return $video;
    }

    // Getters y Setters...

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getCategoriaNombre(): ?string
    {
        return $this->categoriaNombre;
    }

    public function setCategoriaNombre(?string $categoriaNombre): void
    {
        $this->categoriaNombre = $categoriaNombre;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): void
    {
        $this->userId = $userId;
    }
}
