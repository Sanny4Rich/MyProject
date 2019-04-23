<?php

namespace App\Controller;

use App\Entity\Review;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\ReviewType;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\UserInterface;
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

    public function renderReview(Request $request)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($review);
            $manager->flush();

            $this->addFlash('info', 'Спасибо за обращение, мы с Вами свяжемся');
        }
        return $this->render('user/reviewInput.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
