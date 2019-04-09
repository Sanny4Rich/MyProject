<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ContactUsRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ProductRepository $productRepository, CategoriesRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        $products = $productRepository->findBy(array('isTop'=> 1));

//        $categories = $this->prepareCategories();
//        var_dump($categories);
            return $this->render('home_page/index.html.twig', [
                'categories' => $categories,
                'products' => $products
        ]);
    }
    /**
     * @Route("/search", name="search")
     */
    public function search(ProductRepository $productRepository, Request $request)
    {
        $query = $request->query->get('q');

        if($query){
            $products = $productRepository->findByName($query);
        }else{
            $products = [];
        }
        return $this->render('home_page/search.html.twig',
            [
                'products' => $products
            ]);
    }


}
