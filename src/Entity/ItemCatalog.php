<?php

namespace App\Entity;

use App\Repository\ItemCatalogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;


#[ORM\Entity(repositoryClass: ItemCatalogRepository::class)]
#[ApiResource]
class ItemCatalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $category = null;

    #[ORM\Column(length: 100)]
    private ?string $style = null;

    #[ORM\Column(length: 255)]
    private ?string $imageSvg = null;

    #[ORM\Column]
    private ?int $defaultWidth = null;

    #[ORM\Column]
    private ?int $defaultHeight = null;

    /**
     * @var Collection<int, PlacedItem>
     */
    #[ORM\OneToMany(targetEntity: PlacedItem::class, mappedBy: 'catalogItem')]
    private Collection $placedItems;

    public function __construct()
    {
        $this->placedItems = new ArrayCollection();
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getImageSvg(): ?string
    {
        return $this->imageSvg;
    }

    public function setImageSvg(string $imageSvg): static
    {
        $this->imageSvg = $imageSvg;

        return $this;
    }

    public function getDefaultWidth(): ?int
    {
        return $this->defaultWidth;
    }

    public function setDefaultWidth(int $defaultWidth): static
    {
        $this->defaultWidth = $defaultWidth;

        return $this;
    }

    public function getDefaultHeight(): ?int
    {
        return $this->defaultHeight;
    }

    public function setDefaultHeight(int $defaultHeight): static
    {
        $this->defaultHeight = $defaultHeight;

        return $this;
    }

    /**
     * @return Collection<int, PlacedItem>
     */
    public function getPlacedItems(): Collection
    {
        return $this->placedItems;
    }

    public function addPlacedItem(PlacedItem $placedItem): static
    {
        if (!$this->placedItems->contains($placedItem)) {
            $this->placedItems->add($placedItem);
            $placedItem->setCatalogItem($this);
        }

        return $this;
    }

    public function removePlacedItem(PlacedItem $placedItem): static
    {
        if ($this->placedItems->removeElement($placedItem)) {
            // set the owning side to null (unless already changed)
            if ($placedItem->getCatalogItem() === $this) {
                $placedItem->setCatalogItem(null);
            }
        }

        return $this;
    }
}
