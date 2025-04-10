<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Song>
     */
    #[ORM\ManyToMany(targetEntity: Song::class, inversedBy: 'playlists')]
    private Collection $playlistSong;

    /**
     * @var Collection<int, Vibe>
     */
    #[ORM\OneToMany(targetEntity: Vibe::class, mappedBy: 'playlist')]
    private Collection $vibes;

    public function __construct()
    {
        $this->playlistSong = new ArrayCollection();
        $this->vibes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getPlaylistSong(): Collection
    {
        return $this->playlistSong;
    }

    public function addPlaylistSong(Song $playlistSong): static
    {
        if (!$this->playlistSong->contains($playlistSong)) {
            $this->playlistSong->add($playlistSong);
        }

        return $this;
    }

    public function removePlaylistSong(Song $playlistSong): static
    {
        $this->playlistSong->removeElement($playlistSong);

        return $this;
    }

    /**
     * @return Collection<int, Vibe>
     */
    public function getVibes(): Collection
    {
        return $this->vibes;
    }

    public function addVibe(Vibe $vibe): static
    {
        if (!$this->vibes->contains($vibe)) {
            $this->vibes->add($vibe);
            $vibe->setPlaylist($this);
        }

        return $this;
    }

    public function removeVibe(Vibe $vibe): static
    {
        if ($this->vibes->removeElement($vibe)) {
            // set the owning side to null (unless already changed)
            if ($vibe->getPlaylist() === $this) {
                $vibe->setPlaylist(null);
            }
        }

        return $this;
    }
}
