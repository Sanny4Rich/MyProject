<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 */
class OrderItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $count;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ProductPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $SummaryPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="items")
     */
    private $orders;



    public function __construct()
    {
        $this->count = 0;
        $this->ProductPrice = 0;
        $this->SummaryPrice = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->ProductPrice;
    }

    public function setProductPrice(?int $ProductPrice): self
    {
        $this->ProductPrice = $ProductPrice;

        return $this;
    }

    public function getSummaryPrice(): ?int
    {
        return $this->SummaryPrice;
    }

    public function setSummaryPrice(?int $SummaryPrice): self
    {
        $this->SummaryPrice = $SummaryPrice;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->Orders;
    }

    public function setOrders(?Orders $Orders): self
    {
        $this->Orders = $Orders;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->Products;
    }

    public function setProduct(?Products $Product): self
    {
        $this->Products = $Product;

        return $this;
    }
}
