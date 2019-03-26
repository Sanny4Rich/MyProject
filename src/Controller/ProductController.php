<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
