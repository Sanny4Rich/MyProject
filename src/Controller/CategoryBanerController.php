<?php

namespace App\Controller;

use App\Service\CategoryBanner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryBanerController extends AbstractController
{
    /**
     * @Route("/category/baner", name="category_baner")
     */
    public function categories(CategoryBanner $categoryBanner){
        $categories = $categoryBanner->saveCategoriesToSession();


        return $this->render('categoryBaner/index.html.twig', [
            'categories' => $categories,
        ]);
    }


}
