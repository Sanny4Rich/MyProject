<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Product;
use App\Repository\CategoriesRepository;
use App\Repository\ProductRepository;
use DateInterval;
use Doctrine\ORM\EntityManager;
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

        $products = $productRepository->createQueryBuilder('q');
        $products->addSelect('a')
            ->leftJoin('q.images', 'a');
        $products->getQuery()->getResult();
             $categories = $categoriesRepository->findAll();
        $pagination = $paginator->paginate($products, $request->get('page', 1), 12);
        return $this->render('shop/index.html.twig', [
            'products' => $pagination,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/newproducts", name="newProducts")
     */
    public function newProducts(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator){
            $products = $productRepository->createQueryBuilder('q')
                ->orderBy('q.updatedAt', 'desc');
            $products->addSelect('a')
                        ->leftJoin('q.images', 'a');
                $products->getQuery()->getResult();
        $pagination = $paginator->paginate($products, $request->get('page', 1), 12);
         return $this->render('product/newProducts.html.twig', [
             'products' => $pagination,
              ]);
    }

    /**
     * @Route("/priceDrop", name="priceDrop")
     */
    public function priceDporProducts(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator){
        $products = $productRepository->createQueryBuilder('q')
            ->where('q.salePrice IS NOT NULL');
        $products->addSelect('a')
            ->leftJoin('q.images', 'a');
        $products->getQuery()->getResult();
        $pagination = $paginator->paginate($products, $request->get('page', 1), 12);
        return $this->render('product/priceDrop.html.twig', [
            'products' => $pagination,
        ]);
    }
    /**
     * @Route("/bestsale", name="bestSale")
     */
    public function bestSale(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator){
        $products = $productRepository->createQueryBuilder('q')
            ->where('q.isTop = 1');
        $products->addSelect('a')
            ->leftJoin('q.images', 'a');
        $products->getQuery()->getResult();
        $pagination = $paginator->paginate($products, $request->get('page', 1), 12);
        return $this->render('product/bestSale.html.twig', [
            'products' => $pagination,
        ]);
    }

}