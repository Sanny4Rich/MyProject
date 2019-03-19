<?php
/**
 * Created by PhpStorm.
 * User: sanny4rich
 * Date: 27.02.19
 * Time: 19:51
 */

namespace App\Admin;


use App\Form\MoneyTransformer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class OrderItemAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('product')
            ->add('ProductPrice', null, ['attr' =>['class'=>'js-price js-recalc-cost'],])
            ->add('count', null, ['attr' =>['class'=>'js-count js-recalc-cost'],])
            ->add('SummaryPrice', null, ['attr' =>['class'=>'js-summaryPrice'],]);
        $form->get('ProductPrice')->addModelTransformer(new MoneyTransformer());
        $form->get('SummaryPrice')->addModelTransformer(new MoneyTransformer());
    }

}