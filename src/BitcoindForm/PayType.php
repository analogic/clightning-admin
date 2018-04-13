<?php

namespace App\BitcoindForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromAccount', TextType::class, ['label' => 'From account', 'required' => false, 'attr' => ['autofocus' => 'autofocus']])
            ->add('toAddress', TextType::class, ['label' => 'To address'])
            ->add('amount', TextType::class, ['label' => 'Amount (BTC)'])
            ->add('minconf', NumberType::class, ['label' => 'minconf', 'required' => false])
            ->add('comment', NumberType::class, ['label' => 'comment', 'required' => false])
            ->add('commentTo', NumberType::class, ['label' => 'comment-to', 'required' => false])
            ->add('fee', TextType::class, ['label' => 'Tx fee (satoshi/byte)', 'required' => false])

            ->add('Pay!', SubmitType::class)
        ;
    }
}