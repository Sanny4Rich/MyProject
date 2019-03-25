<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductRepository;
use App\Service\CategoryBanner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ProductRepository $productRepository, CategoriesRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
//        $categories = $this->prepareCategories();
//        var_dump($categories);
            return $this->render('home_page/index.html.twig', [
                'categories' => $categories,

        ]);
    }

}
