<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function index(ProductRepository $productRepository, CategoriesRepository $categoriesRepository)
    {
        $products = $productRepository->findAll();
        $categories = $categoriesRepository->findAll();
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
