<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductRepository;
use App\Service\GetNamesFromRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryBanerController extends AbstractController
{
    /**
     * @Route("/category/baner", name="category_baner")
     */
    public function index(ProductRepository $productRepository, CategoriesRepository $categoryRepository)
    {

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

        $category = new GetNamesFromRepository($category);
        $tree = $categoryRepository->childrenHierarchy(
             $categoryRepository->findOneBy($category),
            null,
            $options
        );
        dump($tree);

        return $this->render('categoryBaner/index.html.twig', [
            'products' => $products,
            'tree' => $tree,
            'name' => $name,
            ''
        ]);
    }
}


