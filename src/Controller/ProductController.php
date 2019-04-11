<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use FOS\UserBundle\FOSUserBundle;
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
        $relatedProductsCat = $product->getCategories();
        $relatedProducts = $productRepository->findBy(['categories'=>$relatedProductsCat, 'isTop'=> true ] );
        if (!$product) {
            throw $this->$this->createNotFoundException('Товар #' . $id . ' не найден');
        }
        return $this->render('product/item.html.twig', [
            'product'=>$product,
            'relatedProducts' => $relatedProducts
            ]);
    }
}
