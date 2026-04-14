<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;


#[ORM\Entity(repositoryClass: PlanRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $width = null;

    #[ORM\Column]
    private ?int $height = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'plans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     * @var Collection<int, PlacedItem>
     */
    #[ORM\OneToMany(mappedBy: 'plan', targetEntity: PlacedItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $placedItems;

    /**
     * @var Collection<int, Recommendation>
     */
    #[ORM\OneToMany(mappedBy: 'plan', targetEntity: Recommendation::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $recommendations;

    public function __construct()
    {
        $this->placedItems = new ArrayCollection();
        $this->recommendations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;
        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;
        return $this;
    }

    public function getPlacedItems(): Collection
    {
        return $this->placedItems;
    }

    public function addPlacedItem(PlacedItem $placedItem): static
    {
        if (!$this->placedItems->contains($placedItem)) {
            $this->placedItems->add($placedItem);
            $placedItem->setPlan($this);
        }
        return $this;
    }

    public function removePlacedItem(PlacedItem $placedItem): static
    {
        if ($this->placedItems->removeElement($placedItem)) {
            if ($placedItem->getPlan() === $this) {
                $placedItem->setPlan(null);
            }
        }
        return $this;
    }

    public function getRecommendations(): Collection
    {
        return $this->recommendations;
    }

    public function addRecommendation(Recommendation $recommendation): static
    {
        if (!$this->recommendations->contains($recommendation)) {
            $this->recommendations->add($recommendation);
            $recommendation->setPlan($this);
        }
        return $this;
    }

    public function removeRecommendation(Recommendation $recommendation): static
    {
        if ($this->recommendations->removeElement($recommendation)) {
            if ($recommendation->getPlan() === $this) {
                $recommendation->setPlan(null);
            }
        }
        return $this;
    }

    #[ORM\PrePersist]
    public function initializeCreatedAt(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime();
        }
    }

    #[ORM\PreUpdate]
    public function updateUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }
}