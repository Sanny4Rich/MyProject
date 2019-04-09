<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function index(ProductRepository $productRepository,Request $request,  CategoriesRepository $categoriesRepository, PaginatorInterface $paginator)
    {

        $products = $productRepository->findAll();
             $categories = $categoriesRepository->findAll();
        $pagination = $paginator->paginate($products, $request->get('page', 1), 12);
        return $this->render('shop/index.html.twig', [
            'products' => $pagination,
            'categories' => $categories
        ]);
    }
}