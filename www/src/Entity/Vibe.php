<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VibeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VibeRepository::class)]
class Vibe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['vibe:read'])]
    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[Groups(['vibe:read'])]
    #[ORM\Column(length: 255)]
    private ?string $energy = null;

    #[Groups(['vibe:read'])]
    #[ORM\Column(length: 255)]
    private ?string $stress = null;

    #[Groups(['vibe:read'])]
    #[ORM\Column(length: 255)]
    private ?string $motivation = null;

    #[ORM\ManyToOne(inversedBy: 'vibes')]
    private ?Profile $profile = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'vibes')]
    private ?Playlist $playlist = null;

    /**
     * @var Collection<int, DeviceSetting>
     */
    #[ORM\OneToMany(targetEntity: DeviceSetting::class, mappedBy: 'vibe')]
    private Collection $deviceSettings;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'vibe')]
    private Collection $events;

    public function __construct()
    {
        $this->deviceSettings = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getStress(): ?string
    {
        return $this->stress;
    }

    public function setStress(string $stress): static
    {
        $this->stress = $stress;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): static
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
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

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return Collection<int, DeviceSetting>
     */
    public function getDeviceSettings(): Collection
    {
        return $this->deviceSettings;
    }

    public function addDeviceSetting(DeviceSetting $deviceSetting): static
    {
        if (!$this->deviceSettings->contains($deviceSetting)) {
            $this->deviceSettings->add($deviceSetting);
            $deviceSetting->setVibe($this);
        }

        return $this;
    }

    public function removeDeviceSetting(DeviceSetting $deviceSetting): static
    {
        if ($this->deviceSettings->removeElement($deviceSetting)) {
            // set the owning side to null (unless already changed)
            if ($deviceSetting->getVibe() === $this) {
                $deviceSetting->setVibe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setVibe($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getVibe() === $this) {
                $event->setVibe(null);
            }
        }

        return $this;
    }
}
