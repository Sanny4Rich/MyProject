<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    /**
     * @Route("/products/{id}", name="products_item")
     */
    public function item($id, ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);
        if (!$product){
            throw $this->$this->createNotFoundException('Товар #'.$id.' не найден');
        }

        return $this->render('product/item.html.twig', [
            'product'=>$product,]);
    }

    /**
     * @Route("/search", name="search")
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
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
