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

    private $mailer;

    private $parameters;

    public function __construct(
        RequestStack $requestStack,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager,
        Environment $twig,
        \Swift_Mailer $mailer,
        ParameterBagInterface $parameters
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->ordersRepository = $orderRepository;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->mailer = $mailer;
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
            $order->setFirstName($user->getFirstName());
            $order->setLastName($user->getLastName());
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
        $this->sendEmail($thibaners->parameters->get('adminEmail'), 'mail/newOrderForAdmin.html.twig', ['order' => $order]);
        $this->sendEmail($order->getEmail(), 'mail/newOrderForUser.html.twig', ['order' => $order]);
    }

    private function sendEmail(string $to,$templateName, array $context)
    {
        $template = $this->twig->load($templateName);
        $subject = $template->renderBlock('subject', $context);
        $body =$template->renderBlock('body', $context);

        $massage = new \Swift_Message();
        $massage->setSubject($subject);
        $massage->setBody($body, 'text/html');
        $massage->setTo($to);
        $massage->setFrom($this->parameters->get('fromEmail'), $this->parameters->get('fromName'));
        $this->mailer->send($massage);

    }
}