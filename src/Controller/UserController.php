<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\UserInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function userPanelInHeader()
    {
        return $this->render('user/_myAccountInHeader.html.twig', [
        ]);
    }

    /**
     * @Route("/user_orders", name="userOrders")
     */

    public function userOrders(UserInterface $user = null , UserRepository $userRepository ){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $usr = $userRepository->find($user->getId());
        return $this->render('user/userOrders.html.twig',[
            'user' => $usr,
        ]);
    }
}
