<?php

namespace App\Entity;

use App\Entity\Vibe;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfileRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]

#[ApiResource(
    //autorisation des route que l'on veut acceder
    operations: [
        new Get(),
        new GetCollection(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['profile:read']],
    denormalizationContext: ['groups' => ['profile:write']]
)]


class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['profile:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['profile:read', 'profile:write'])]
    private ?string $username = null;

    #[ORM\Column(length: 4)]
    #[Groups(['profile:read', 'profile:write'])]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'profiles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

    /**
     * @var Collection<int, Vibe>
     */
    #[ORM\OneToMany(targetEntity: Vibe::class, mappedBy: 'profile')]
    private Collection $vibes;

    public function __construct()
    {
        $this->vibes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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
            $vibe->setProfile($this);
        }

        return $this;
    }

    public function removeVibe(Vibe $vibe): static
    {
        if ($this->vibes->removeElement($vibe)) {
            // set the owning side to null (unless already changed)
            if ($vibe->getProfile() === $this) {
                $vibe->setProfile(null);
            }
        }

        return $this;
    }
}
