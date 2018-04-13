<?php

namespace App\BitcoindForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account', TextType::class, ['label' => 'Account', 'required' => false, 'attr' => ['autofocus' => 'autofocus']])
            ->add('type', ChoiceType::class, array(
                'required' => false,
                'choices'  => array(
                    'legacy' => 'legacy',
                    'p2sh-segwit' => 'p2sh-segwit',
                    'bech32' => 'bech32',
                ),
            ))
            ->add('Generate!', SubmitType::class)
        ;
    }
}