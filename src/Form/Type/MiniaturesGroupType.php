<?php

namespace App\Form\Type;

use App\Entity\Qualities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MiniaturesGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('brand')
            ->add('quantity')
            ->add('scale', EntityType::class, [
                'class' => Qualities::class,
                'choice_label' => 'name'
            ])
            ->add('quality', EntityType::class, [
                'class' => Qualities::class, //lien avec l'autre classe ?
                'choice_label' => 'name'
            ])
            ->add('wantBuilt')
            ->add('comment')
            
        ;
    }
}