<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('milliSatoshi', NumberType::class, ['label' => 'Amount in millisatoshi (1satoshi = 1000msatoshi)', 'attr' => ['autofocus' => 'autofocus']])
            ->add('label', TextType::class, ['label' => 'Label (unique identifier for invoice)'])
            ->add('description')
            ->add('expiry', NumberType::class, ['label' => 'Expiry (invoice expiration in seconds)'])
            ->add('Create!', SubmitType::class)
        ;
    }
}