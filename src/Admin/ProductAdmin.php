<?php

namespace App\Admin;


use App\Entity\Product;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductAdmin extends AbstractAdmin
{
    /**
     * @var CacheManager
     *
     */
    private $cacheManager;

    public function __construct(string $code, string $class, string $baseControllerName, CacheManager $cacheManager)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->cacheManager = $cacheManager;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('description')
            ->addIdentifier('price')
            ->addIdentifier('categories')
            ->addIdentifier('image');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id', null , ['label' => 'Название'])
            ->add('name')
            ->add('description')
            ->add('categories')
            ->add('price');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $cacheManager = $this->cacheManager;

        $form
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('isTop')
            ->add('categories')
            ->add('attributeValues',
                CollectionType::class,
                ['by_reference' => false
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            )
            ->add('image', VichImageType::class, [
                'required' => false,
                'allow_delete'=> true,
                'image_uri' => function (Product $product, $resolverdUri) use ($cacheManager) {
                    // $cacheManager is LiipImagine cache Manager
                    if (!$resolverdUri) {
                        return null;
                    }
                    return $cacheManager->getBrowserPath($resolverdUri, 'squared_thumbnail');
                }
            ]);
    }
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('attributes', $this->getRouterIdParameter() . '/attributes', [
            '_controller' => $this->getBaseControllerName() . ':editAction',
        ]);
    }
}