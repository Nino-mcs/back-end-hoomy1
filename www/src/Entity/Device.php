<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'devices')]
    private ?Room $room = null;

    #[ORM\ManyToOne(inversedBy: 'devices')]
    private ?DeviceType $deviceType = null;

    /**
     * @var Collection<int, DeviceSetting>
     */
    #[ORM\OneToMany(targetEntity: DeviceSetting::class, mappedBy: 'device')]
    private Collection $deviceSettings;

    /**
     * @var Collection<int, DeviceSetting>
     */
    #[ORM\OneToMany(targetEntity: DeviceSetting::class, mappedBy: 'device')]
    private Collection $deviceSetting;


    public function __construct()
    {
        $this->deviceSettings = new ArrayCollection();
        $this->deviceSetting = new ArrayCollection();
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getDeviceType(): ?DeviceType
    {
        return $this->deviceType;
    }

    public function setDeviceType(?DeviceType $deviceType): static
    {
        $this->deviceType = $deviceType;

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
            $deviceSetting->setDevice($this);
        }

        return $this;
    }

    public function removeDeviceSetting(DeviceSetting $deviceSetting): static
    {
        if ($this->deviceSettings->removeElement($deviceSetting)) {
            // set the owning side to null (unless already changed)
            if ($deviceSetting->getDevice() === $this) {
                $deviceSetting->setDevice(null);
            }
        }

        return $this;
    }
}
