<?php

namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class OrdersService
{

    private $request;

    private $ordersRepository;

    private $entityManager;

    private $twig;

    private $parameters;

    public function __construct(
        RequestStack $requestStack,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager,
        Environment $twig,
        ParameterBagInterface $parameters
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->ordersRepository = $orderRepository;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->parameters = $parameters;
    }

    public function addToCart(Product $product): Order
    {
        $order = $this->getOrderFromRequest();
        $items = $order->getItems();

        if ($items[$product->getId()]) {
            $items[$product->getId()]->addCount(1);
        } else {
            $item = new OrderItem();
            $item->setProduct($product);
            $item->setCount(1);
            $order->addItem($item);
            $this->entityManager->persist($item);
        }

        $this->entityManager->flush();

        return $order;
    }

    public function getOrderFromRequest()
    {
        $order = null;
        $orderId = $this->request->cookies->get('orderId');

        if ($orderId){
            $order = $this->ordersRepository->find($orderId);
        }

        if (!$order){
            $order = new Order();
            $this->entityManager->persist($order);
        }

        return $order;

    }

    public function removeItemFromCart(OrderItem $item)
    {
        $cart = $this->getOrderFromRequest();
        $order = $item->getOrders();
        if($cart !== $order){
            return;
        }

        $order = $item->getOrders();
        $order->removeItem($item);
        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }

    public function setItemCount(OrderItem $item, $count)
    {
        $cart = $this->getOrderFromRequest();
        $order = $item->getOrders();
        if($cart !== $order){
            return;
        }
        if($count<1)
        {
            return;
        }
        $item->setCount($count);
        $this->entityManager->flush();
    }

    public function prepareOrder(?User $user)
    {
        $order = $this->getOrderFromRequest();
        if($user) {
            $order->setName($user->getName());
            $order->setEmail($user->getEmail());
            $order->setPhoneNumber($user->getPhoneNumber());
            $order->setAdress($user->getAdress());
        }
        return $order;
    }

    public function sendOrder(Order $order)
    {
        $order->setStatus(Order::STATUS_ORDERED);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        }
}