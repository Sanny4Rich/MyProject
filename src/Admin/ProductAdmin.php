<?php

namespace App\Admin;


use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\CollectionType;
use Liip\ImagineBundle\Form\Type\ImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProductAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('description')
            ->addIdentifier('price')
            ->addIdentifier('categories');
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
            ->add('images',
                CollectionType::class,
                ['by_reference' => false
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            );
    }
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('attributes', $this->getRouterIdParameter() . '/attributes', [
            '_controller' => $this->getBaseControllerName() . ':editAction',
        ]);
    }
}