<?php

namespace App\Controller;

use App\Entity\Attribute;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories" , name="category")
     */
    public function index(CategoriesRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_item")
     */
    public function item(Categories $category, Request $request, ProductRepository $productRepository, PaginatorInterface $paginator){

        $form = $this->getFilterForm($category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $products =$productRepository->findByAttributes($category, $form->getData());
        }else{
            $products = $category->getProducts();
        };
        $pagination = $paginator->paginate($products, $request->get('page', 1), 12);
        return $this->render('category/items.html.twig',
            ['categories' => $category,
                'filterForm' => $form->createView(),
                'products' => $pagination,
                ]);
    }

    private function getFilterForm(Categories $category){
        $formBuilder = $this->createFormBuilder();
        $formBuilder->setMethod('get');
        foreach ($category->getAttributes() as $attribute){
            switch ($attribute->getType()) {
                case Attribute::TYPE_INT:
                    $formBuilder->add('attr_min_' . $attribute->getId(), NumberType::class, ['required' => false]);
                    $formBuilder->add('attr_max_' . $attribute->getId(), NumberType::class, ['required' => false]);
                    break;

                case Attribute::TYPE_LIST:
                    $getChoices = [];
                    foreach ($category->getProducts() as $items){
                        foreach ($items->getAttributeValues() as $attsVal){
                            if((integer)$attsVal->getAttribute()->getId() == (integer)$attribute->getId()){
                                $attrChoice = $attribute->getChoices();
                                $attrChoice = $attrChoice[$attsVal->getValue()];
                                $attrChoiceId = array_flip($attribute->getChoices());
                                $attrChoiceId = $attrChoiceId[$attrChoice];
                                $getChoices += [ $attrChoiceId=> $attrChoice];
                            }
                        }
                    }
                    $formBuilder->add('attr_' . $attribute->getId(), ChoiceType::class,[
                        'multiple'=> true,
                        'expanded' =>true,
                        'choices' => array_flip($getChoices),
                        'choice_attr' => function($value, $key, $choiceValue){
                            return ['class' => 'custom-control-input'];
                        },
//                        'choice_label' => true,
                    ]);
                    break;
            }
        }

        return $formBuilder->getForm();
    }
}
