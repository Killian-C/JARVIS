<?php

namespace App\Entity;

use App\Repository\AlimentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlimentRepository::class)
 */
class Aliment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="aliments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Unit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prettyName;

    /**
     * @ORM\ManyToOne(targetEntity=ShopPlace::class, inversedBy="aliments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shopPlace;

    public function __toString(): string
    {
        return $this->getName() ?? 'anonymous_aliment';
    }

    public function getNameAndUnit()
    {
        return $this->getName() . ' (' . $this->getUnit()->getName() . ')';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getPrettyName(): ?string
    {
        return $this->prettyName;
    }

    public function setPrettyName(string $prettyName): self
    {
        $this->prettyName = $prettyName;

        return $this;
    }

    public function getShopPlace(): ?ShopPlace
    {
        return $this->shopPlace;
    }

    public function setShopPlace(?ShopPlace $shopPlace): self
    {
        $this->shopPlace = $shopPlace;

        return $this;
    }
}
