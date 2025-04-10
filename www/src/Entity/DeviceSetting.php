<?php

namespace App\Entity;

use App\Repository\DeviceSettingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceSettingRepository::class)]
class DeviceSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'deviceSettings')]
    private ?Vibe $vibe = null;

    #[ORM\ManyToOne(inversedBy: 'deviceSettings')]
    private ?Device $device = null;

    #[ORM\ManyToOne(inversedBy: 'deviceSettings')]
    private ?SettingType $settingType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getVibe(): ?Vibe
    {
        return $this->vibe;
    }

    public function setVibe(?Vibe $vibe): static
    {
        $this->vibe = $vibe;

        return $this;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): static
    {
        $this->device = $device;

        return $this;
    }

    public function getSettingType(): ?SettingType
    {
        return $this->settingType;
    }

    public function setSettingType(?SettingType $settingType): static
    {
        $this->settingType = $settingType;

        return $this;
    }
}
