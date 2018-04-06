<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bolt11', TextType::class, ['label' => 'Payment encoded in BOLT11', 'attr' => ['autofocus' => 'autofocus']])
            ->add('msatoshi', NumberType::class, ['label' => 'Amount in satoshi', 'required' => false])
            ->add('description', null, ['required' => false])
            ->add('riskfactor', null, ['required' => false])
            ->add('maxfeepercent', null, ['required' => false])
            ->add('Pay!', SubmitType::class)
        ;
    }
}