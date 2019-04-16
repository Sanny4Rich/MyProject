<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InfoController extends AbstractController
{
    /**
     * @Route("/legalNotice", name="legalNotice")
     */
    public function legalNotice()
    {
        return $this->render('info/index.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }

    /**
     * @Route("/terms", name="TermsAndCondition")
     */
    public function terms()
    {
        return $this->render('info/termsAndCondition.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }

    /**
     * @Route("/aboutus", name="aboutUs")
     */
    public function aboutUs()
    {
        return $this->render('info/about.us.twig', [
            'controller_name' => 'InfoController',
        ]);
    }

}
