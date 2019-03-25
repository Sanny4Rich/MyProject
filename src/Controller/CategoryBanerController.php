<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryBanerController extends AbstractController
{
    /**
     * @Route("/category/baner", name="category_baner")
     */
    //public function index(ProductRepository $productRepository, CategoriesRepository $categoryRepository)
    public function index(CategoriesRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
//        $categories = $this->prepareCategories();
        var_dump($categories);
        return $this->render('categoryBaner/index2.html.twig', [
            'categories' => $categories,
        ]);

//        $controller = $this;
//        $options = array('decorate'=>true,
//            'rootOpen'=> '<br>',
//            'rootClose' => '<br>',
//            'childOpen' => '<br>',
//            'childClose' => '<br>',
//            'representationField' => 'name',
//            'html' => true,
//            'nodeDecorator' => function($node) use ($controller) {
//                $url = $controller->generateUrl('category_item', ['id' => $node['id']]);
//                return '<a href="' . $url . '">' . $node['name'] . '</a>';});
//        $alltree = $categoryRepository->findAll();
//
//        $tree = $categoryRepository->childrenHierarchy(null,
//            null,
//            $options
//        );

        return $this->render('categoryBaner/index.html.twig', [
            'products' => $products,
            'tree' => $tree,
        ]);
    }

    private function prepareCategorie($categories): array
    {
        $result = [
            1 => [
                'name' => 'test 1',
                'childrens' => [
                    2 => [
                        'name test 1.1'
                    ],
                ],
            ],
            12 => [

            ],
        ];

        return $result;
    }
}


