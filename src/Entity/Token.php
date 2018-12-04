<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 */
class Token
{
    const TOKEN_LENGTH = 6;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6, unique=true)
     */
    private $value;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Album", mappedBy="token")
     */
    protected $album;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Artist", mappedBy="token")
     */
    protected $artist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * @return Album
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
    }
}
