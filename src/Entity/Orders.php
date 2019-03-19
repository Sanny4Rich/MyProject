<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 * @ORM\Table(name="Users")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", options={"default": 1})
     */
    private $status;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $pay_status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $OrderPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"createOrder"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(groups={"createOrder"}, pattern="|^[-+ \d\(\)]+$|")
     */
    private $phonenumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"createOrder"})
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"createOrder"})
     * @Assert\Email(groups={"createOrder"})
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="orders",
     *     orphanRemoval=true, indexBy="product_id", cascade={"persist"})
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayStatus(): ?int
    {
        return $this->pay_status;
    }

    public function setPayStatus(?int $pay_status): self
    {
        $this->pay_status = $pay_status;

        return $this;
    }

    public function getOrderPrice(): ?int
    {
        return $this->OrderPrice;
    }

    public function setOrderPrice(?int $OrderPrice): self
    {
        $this->OrderPrice = $OrderPrice;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setOrders($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getOrders() === $this) {
                $item->setOrders(null);
            }
        }

        return $this;
    }
}
