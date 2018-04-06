<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ConnectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, ['label' => 'ID of node', 'attr' => ['autofocus' => 'autofocus']])
            ->add('host', TextType::class, ['label' => 'Connect to host[:port]'])
            ->add('Connect!', SubmitType::class)
        ;
    }
}