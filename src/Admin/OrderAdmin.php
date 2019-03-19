<?php

namespace App\Admin;

use App\Form\MoneyTransformer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderAdmin extends AbstractAdmin
{

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('createdAt')
            ->addIdentifier('status')
            ->addIdentifier('PayStatus')
            ->addIdentifier('firstName')
            ->addIdentifier('lastName')
            ->addIdentifier('OrderPrice', null, ['template' => 'admin/order/_amount.html.twig'])
            ->addIdentifier('user')
            ->addIdentifier('PhoneNumber')
            ->addIdentifier('adress');

    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('user')
            ->add('createdAt')
            ->add('OrderPrice');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('createdAt')
            ->add('status')
            ->add('PayStatus')
            ->add('firstName')
            ->add('lastName')
            ->add('OrderPrice', TextType::class)
            ->add('user')
            ->add('PhoneNumber')
            ->add('adress')
            ->add('items', CollectionType::class, ['by_reference' => false], [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            );
        $form->get('OrderPrice')->addModelTransformer(new MoneyTransformer());
    }
}