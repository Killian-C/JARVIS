<?php

namespace App\Entity;

use App\Repository\ShiftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShiftRepository::class)
 */
class Shift
{
    const SHIFT_IDENTIFIER = [
        'Lundi midi',
        'Lundi soir',
        'Mardi midi',
        'Mardi soir',
        'Mercredi midi',
        'Mercredi soir',
        'Jeudi midi',
        'Jeudi soir',
        'Vendredi midi',
        'Vendredi soir',
        'Samedi midi',
        'Samedi soir',
        'Dimanche midi',
        'Dimanche soir',
    ];

    public const DAYS_INDEX_SHIFT_INDENTIFIER = [
        'Monday'    => 0,
        'Tuesday'   => 2,
        'Wednesday' => 4,
        'Thursday'  => 6,
        'Friday'    => 8,
        'Saturday'  => 10,
        'Sunday'    => 12,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifier;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="shifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity=Dish::class, mappedBy="shift", cascade={"persist"})
     */
    private $dishes;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->dishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * @return Collection|Dish[]
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes[] = $dish;
            $dish->setShift($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getShift() === $this) {
                $dish->setShift(null);
            }
        }

        return $this;
    }
}
