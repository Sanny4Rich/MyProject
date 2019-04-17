<?php

namespace App\Admin;


use App\Entity\Attribute;
use App\Entity\Categories;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\CollectionType;
use Liip\ImagineBundle\Form\Type\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProductAdmin extends AbstractAdmin
{
    /**
     * @var CacheManager
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
            -> addIdentifier('name')
            -> addIdentifier('id')
            -> add('description')
            -> addIdentifier('price')
            -> addIdentifier('category');
    }
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            -> add('id')
            -> add('name')
            -> add('price');
    }
    protected function configureFormFields(FormMapper $form)
    {
        $cacheManager = $this->cacheManager;
        //Вкладка с товарами
        $form
            ->tab('Товар')
            ->with('Товар')
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('salePrice')
            ->add('categories')
            ->add('isTop')
            ->end()
            ->end();
        //Вкладка с картинками
        $form
            ->tab('Картинки')
            ->with('Картинки')
            ->add('images',
                CollectionType::class,
                ['by_reference' => false
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            )
            ->end()
            ->end();
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('attributes', $this->getRouterIdParameter(). '/attributes', [
            '_controller' => $this->getBaseControllerName(). ':attributesAction',
        ]);
    }
}