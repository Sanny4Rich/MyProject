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
        $categoryOnMainPage =    array(['name'=>"Books & Board Games"],
            ['name'=>"Baby Dolls"],
            ['name'=>"Cameras"],
            ['name'=>"GamePad"],
            ['name'=>"Health & Beauty"],
            ['name'=>"Makeup"],
            ['name'=>"Fruits"],
            ['name'=>"Vegetables"]);

        $products = $productRepository->findBy(
            ['isTop' => true],
            ['name' =>'ASC']);
        $controller = $this;
        $options = array('decorate'=>true,
            'rootOpen'=> '<br>',
            'rootClose' => '<br>',
            'childOpen' => '<br>',
            'childClose' => '<br>',
            'representationField' => 'name',
            'html' => true,
            'nodeDecorator' => function($node) use ($controller) {
                $url = $controller->generateUrl('category_item', ['id' => $node['id']]);
                return '<a href="' . $url . '">' . $node['name'] . '</a>';});

        $category = array();
        $tree = $categoryRepository->childrenHierarchy(
            $categoryRepository->findOneBy($category),
            null,
            $options
        );

            return $this->render('home_page/index.html.twig', [
                'products' => $products,
                'tree' => $tree,
        ]);
    }

}
