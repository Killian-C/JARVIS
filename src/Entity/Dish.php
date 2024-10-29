<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DishRepository::class)
 */
class Dish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Shift::class, inversedBy="dishes")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Shift $shift;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Recipe $recipe;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $peopleCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShift(): ?Shift
    {
        return $this->shift;
    }

    public function setShift(?Shift $shift): self
    {
        $this->shift = $shift;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getPeopleCount(): ?int
    {
        return $this->peopleCount;
    }

    public function setPeopleCount(int $peopleCount): self
    {
        $this->peopleCount = $peopleCount;

        return $this;
    }

    public function getIngredients()
    {
        return $this->getRecipe() ? $this->getRecipe()->getIngredients() : [];
    }
}
