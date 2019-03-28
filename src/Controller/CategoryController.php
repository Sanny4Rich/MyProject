<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories" , name="category")
     */
    public function index(CategoriesRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll(
        );


        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_item")
     */

    public function item(Categories $category){
        return $this->render('category/items.html.twig',
            ['category' => $category,
            ]);

    }

}
