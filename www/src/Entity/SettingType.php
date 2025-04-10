<?php

namespace App\Entity;

use App\Repository\SettingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingTypeRepository::class)]
class SettingType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $dataType = null;

    /**
     * @var Collection<int, DeviceSetting>
     */
    #[ORM\OneToMany(targetEntity: DeviceSetting::class, mappedBy: 'settingType')]
    private Collection $deviceSettings;

    public function __construct()
    {
        $this->deviceSettings = new ArrayCollection();
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

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): static
    {
        $this->dataType = $dataType;

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
            $deviceSetting->setSettingType($this);
        }

        return $this;
    }

    public function removeDeviceSetting(DeviceSetting $deviceSetting): static
    {
        if ($this->deviceSettings->removeElement($deviceSetting)) {
            // set the owning side to null (unless already changed)
            if ($deviceSetting->getSettingType() === $this) {
                $deviceSetting->setSettingType(null);
            }
        }

        return $this;
    }
}
