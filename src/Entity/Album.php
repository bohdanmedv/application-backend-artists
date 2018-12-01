<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Artist", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $artistId;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Token", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tokenId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArtistId(): ?Artist
    {
        return $this->artistId;
    }

    public function setArtistId(Artist $artistId): self
    {
        $this->artistId = $artistId;

        return $this;
    }

    public function getTokenId(): ?Token
    {
        return $this->tokenId;
    }

    public function setTokenId(Token $tokenId): self
    {
        $this->tokenId = $tokenId;

        return $this;
    }
}
