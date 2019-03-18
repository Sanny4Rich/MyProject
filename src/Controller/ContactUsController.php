<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsController extends AbstractController
{
    /**
     * @Route("/contactUs", name="contact_us")
     */
    public function index(Request $request)
    {
        $feedBack = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $feedBack);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($feedBack);
            $manager->flush();

            $this->addFlash('info', 'Спасибо за обращение, мы с Вами свяжемся');
            return $this->redirectToRoute('home_page');
        }
        return $this->render('contact_us/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
