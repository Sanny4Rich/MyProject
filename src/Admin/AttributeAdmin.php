<?php
namespace App\Admin;

use App\Entity\Atributes;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AttributeAdmin extends AbstractAdmin{

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('type', null, [
                'template' => 'admin/attribute/_type.html.twig',
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('type', null, [], ChoiceType::class, [
                'choices' => [
                    'atribute.type.' . Atributes::TYPE_INT => Atributes::TYPE_INT,
                    'atribute.type.' . Atributes::TYPE_LIST => Atributes::TYPE_LIST,
                ]
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name')
            ->add('type', ChoiceType:: class, [
                'choices' => [
                    'atribute.type.' .Atributes::TYPE_INT => Atributes::TYPE_INT,
                    'atribute.type.' .Atributes::TYPE_LIST => Atributes::TYPE_LIST,
                ]
            ]);
    }
}