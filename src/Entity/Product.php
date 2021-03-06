<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Imagine\Gd\Image;

/**
 *  Class Product
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTop;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributeValues", mappedBy="product", orphanRemoval=true
     *     , indexBy="attribute.id", cascade={"all"}))
     */
    private $attributeValues;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="products")
     */
    private $categories;

    /**
     * @var Images[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Images", mappedBy="product", cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salePrice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="product")
     */
    private $orderItems;



    public function __construct()
    {
        $this->isTop = false;
        $this->orderItems = new ArrayCollection();
        $this->attributeValues = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->updatedAt = new \DateTime('now');
    }

    public function __toString()
    {
        return (string)$this->getName();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function realPrice(): ?float{
        return $this->getPrice()/100;
    }

    public function realSalePrice(): ?float{
        return $this->getSalePrice()/100;
    }

    public function getIsTop(): ?bool
    {
        return $this->isTop;
    }

    public function setIsTop(?bool $isTop): self
    {
        $this->isTop = $isTop;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setProduct($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getProduct() === $this) {
                $orderItem->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttributeValues[]
     */
    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }

    public function addAttributeValue(AttributeValues $attributeValue): self
    {
        if (!$this->attributeValues->contains($attributeValue)) {
            $this->attributeValues[$attributeValue->getAttribute()->getId()] = $attributeValue;
            $attributeValue->setProduct($this);
        }

        return $this;
    }

    public function removeAttributeValue(AttributeValues $attributeValue): self
    {
        if ($this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->removeElement($attributeValue);
            // set the owning side to null (unless already changed)
            if ($attributeValue->getProduct() === $this) {
                $attributeValue->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Images[]|ArrayCollection
     */

    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add image
     *
     * @param Images $image
     *
     * @return Product
     */

    public function addImage(Images $image)
    {
        $image->setProduct($this);
        $this->images[] = $image;

        dump($image);

        return $this;
    }

    public function removeImage(Images $images): self
    {
        if ($this->images->contains($images)) {
            $this->images->removeElement($images);
            // set the owning side to null (unless already changed)
            if ($images->getProduct() === $this) {
                $images->setProduct(null);
            }
        }

        return $this;
    }

    public function getSalePrice(): ?int
    {
        return $this->salePrice;
    }

    public function setSalePrice(?int $salePrice): self
    {
        $this->salePrice = $salePrice;

        return $this;
    }


}