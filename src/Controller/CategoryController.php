<?php

namespace App\Controller;

use App\Entity\Attribute;
use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Product;
use App\Repository\AtributesRepository;
use App\Repository\AttributeValuesRepository;
use App\Repository\CategoriesRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Entity\Repository\CategoryRepository;
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
    public function item(Categories $category, CategoriesRepository $categoryRepository, Request $request, ProductRepository $productRepository, PaginatorInterface $paginator, AttributeValuesRepository $attributeValuesRepository)
    {
        $filter = $attributeValuesRepository->getFilterByAttributes($category);

        $productsFromCategory = $productRepository->createQueryBuilder('q');
        $productsFromCategory->addSelect('a')
            ->leftJoin('q.images', 'a')
            ->where('q.categories = :category')
            ->setParameter('category', $category);
        $productsFromCategory->getQuery()->getResult();

        $form = $this->getFilterForm($filter);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $products =$productRepository->findByAttributes($category, $form->getData());
        }else{
            $products = $productsFromCategory;
        };
        $pagination = $paginator->paginate($products, $request->get('page', 1), 12);
        return $this->render('category/items.html.twig',
            ['categories' => $category,
                'filterForm' => $form->createView(),
                'products' => $pagination,
                ]);
    }

    private function getFilterForm($filter)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->setMethod('get');
        foreach ($filter as $attribute) {
            switch ($attribute->getAttribute()->getType()) {
                case Attribute::TYPE_INT:
                    $formBuilder->add('attr_min_' . $attribute->getAttribute()->getId(), NumberType::class, ['required' => false]);
                    $formBuilder->add('attr_max_' . $attribute->getAttribute()->getId(), NumberType::class, ['required' => false]);
                    break;

                case Attribute::TYPE_LIST:
                    $getChoices = [];
                    foreach ($filter as $atrs) {
                        if ($atrs->getAttribute()->getId() == $attribute->getAttribute()->getId()) {
                            $choiceId = $atrs->getValue();
                            $attrChoice = $atrs->getAttribute()->getChoices();
                            $attrChoice = $attrChoice[$choiceId];
                            $getChoices += [$choiceId => ($attrChoice)];
                            }
                        }
                    krsort($getChoices);
                    reset($getChoices);
                    $formBuilder->add('attr_' . $attribute->getAttribute()->getId(), ChoiceType::class, [
                        'multiple'=> true,
                        'expanded' =>true,
                        'choices' => array_flip($getChoices),
                        'choice_attr' => function($value, $key, $choiceValue){
                            return ['class' => 'custom-control-input'];
                        },
                    ]);
                    break;
            }
        }

        return $formBuilder->getForm();
    }

}
