<?php

namespace App\Controller;

use App\Entity\Attribute;
use App\Repository\AttributeValuesRepository;
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
        $attributes = [];
        $prod = $product->getAttributeValues();
        foreach ($prod as $attributeValues) {

            switch ($attributeValues->getAttribute()->getType()) {
                case Attribute::TYPE_INT:
                    $attr = $attributeValues->getAttribute()->getName();
                    $val = $attributeValues->getValue() . ' ' . $attributeValues->getAttribute()->getDimension();
                    array_push($attributes, [$attr => $val]);
                    break;
                case Attribute::TYPE_LIST:
                    foreach ($attributeValues->getAttribute()->getChoices() as $key => $choice) {
                        $attr = $attributeValues->getAttribute()->getName();
                        $val = '';
                        if ($key = (integer)$attributeValues->getValue()) {
                            $val = $choice . ' ' . $attributeValues->getAttribute()->getDimension();
                            array_push($attributes, [$attr => $val]);
                        }
                        break;
                    }
                    break;
            }
        }

        $relatedProductsCat = $product->getCategories();
        $relatedProducts = $productRepository->findBy(['categories'=>$relatedProductsCat, 'isTop'=> true ] );
        if (!$product) {
            throw $this->$this->createNotFoundException('Товар #' . $id . ' не найден');
        }
        return $this->render('product/item.html.twig', [
            'product'=>$product,
            'relatedProducts' => $relatedProducts,
            'attributes' => $attributes
        ]);
    }
}
