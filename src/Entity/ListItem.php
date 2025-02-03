<?php

namespace App\Entity;

use App\Repository\ListItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListItemRepository::class)
 */
class ListItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $content;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $quantity;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $checked = false;

    /**
     * @ORM\ManyToOne(targetEntity=ShoppingList::class, inversedBy="listItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private ShoppingList $shoppingList;

    /**
     * @ORM\ManyToOne(targetEntity=ShopPlace::class, inversedBy="listItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private ShopPlace $shopPlace;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(?bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shoppingList;
    }

    public function setShoppingList(?ShoppingList $shoppingList): self
    {
        $this->shoppingList = $shoppingList;

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
