<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    const STATUS_NEW = 1; // новый
    const STATUS_ORDERED = 2; //заказан
    const STATUS_SENT = 3; //отправлен
    const STATUS_RECIVED = 4;//получен
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
    private $PayStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $OrderPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     * @Assert\Email(groups={"createOrder"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     * @Assert\Regex(groups={"createOrder"}, pattern="|^[-+ \d\(\)]+$|")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     */
    private $adress;

    /**
     * @var OrderItem[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="Orders",
     *     orphanRemoval=true, indexBy="product_id", cascade={"persist"})
     *
     */
    private $items;

    public function __toString()
    {
        return (string)$this->getName();
    }

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt= new \DateTime();
        $this->status = self::STATUS_NEW;
        $this->OrderPrice = 0;
        $this->PayStatus = false;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayStatus(): ?bool
    {
        return $this->PayStatus;
    }

    public function setPayStatus(bool $PayStatus): self
    {
        $this->PayStatus = $PayStatus;

        return $this;
    }

    public function getOrderPrice(): ?int
    {
        return $this->OrderPrice;
    }

    public function setOrderPrice(int $OrderPrice): self
    {
        $this->OrderPrice = $OrderPrice;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

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

        $this->updateOrderPrice();
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

        $this->updateOrderPrice();

        return $this;
    }

    public function updateOrderPrice(){
        $orderPrice = 0;
        foreach ($this->getItems() as $item){
            $orderPrice += $item->getSummaryPrice();
        }

        $this->setOrderPrice($orderPrice);
    }

}
