<?php

namespace App\Controller;

use App\Service\CategoryBanner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index()
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

}
