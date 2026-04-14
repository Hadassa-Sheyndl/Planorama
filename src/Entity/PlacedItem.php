<?php

namespace App\Entity;

use App\Repository\PlacedItemRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;


#[ORM\Entity(repositoryClass: PlacedItemRepository::class)]
#[ApiResource]
class PlacedItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $x = null;

    #[ORM\Column]
    private ?int $y = null;

    #[ORM\Column]
    private ?int $rotation = null;

    #[ORM\Column]
    private ?int $currentWidth = null;

    #[ORM\Column]
    private ?int $currentHeight = null;

    #[ORM\ManyToOne(inversedBy: 'placedItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plan $plan = null;

    #[ORM\ManyToOne(inversedBy: 'placedItems')]
    #[ORM\JoinColumn(nullable: true)]
    private ?ItemCatalog $catalogItem = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): static
    {
        $this->x = $x;
        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): static
    {
        $this->y = $y;
        return $this;
    }

    public function getRotation(): ?int
    {
        return $this->rotation;
    }

    public function setRotation(int $rotation): static
    {
        $this->rotation = $rotation;
        return $this;
    }

    public function getCurrentWidth(): ?int
    {
        return $this->currentWidth;
    }

    public function setCurrentWidth(int $currentWidth): static
    {
        $this->currentWidth = $currentWidth;
        return $this;
    }

    public function getCurrentHeight(): ?int
    {
        return $this->currentHeight;
    }

    public function setCurrentHeight(int $currentHeight): static
    {
        $this->currentHeight = $currentHeight;
        return $this;
    }

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(?Plan $plan): static
    {
        $this->plan = $plan;
        return $this;
    }

    public function getCatalogItem(): ?ItemCatalog
    {
        return $this->catalogItem;
    }

    public function setCatalogItem(?ItemCatalog $catalogItem): static
    {
        $this->catalogItem = $catalogItem;
        return $this;
    }
}