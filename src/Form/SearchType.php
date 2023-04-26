<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'required' => false,
                'label' => 'Ville',
            ])
            ->add('availability', DateTimeType::class, [
                'required' => false,
                'label' => 'Date et heure',
            ])
            ->add('item', TextType::class, [
                'required' => false,
                'label' => 'Ingrédient ou plat',
            ])
            ->add('category', ChoiceType::class, [
                'required' => false,
                'label' => 'Type de cuisine',
                'choices' => [
                    'Cuisine française' => 'french',
                    'Cuisine asiatique' => 'asian',
                    'Cuisine italienne' => 'italian',
                    'Cuisine africaine' => 'african',
                    'Cuisine indienne' => 'indian',
                    'Cuisine libanaise' => 'lebanese',
                    'Cuisine mexicaine' => 'mexican',
                    'Cuisine orientale' => 'oriental',
                ],
            ])
            ->add('diet', CheckboxType::class, [
                'required' => false,
                'label' => 'Régime alimentaire',
                'attr' => [
                    'Végétarien' => 'vegetarian',
                    'Sans gluten' => 'gluten_free',
                    'Végan' => 'vegan',
                    'Halal' => 'halal',
                    'Casher' => 'kosher',
                ],
            ])
            ->add('price', IntegerType::class, [
                'required' => false,
                'label' => 'Fourchette de prix',
                'attr' => [
                    'placeholder' => '€€ - €€€',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Recherche',
                'attr' => [
                    'class' => 'btn btn-success',
                ],
            ]);
    }
}
