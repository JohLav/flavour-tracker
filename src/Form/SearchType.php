<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Diet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('timeSlot', DateTimeType::class, [
                'required' => false,
                'label' => 'Date et heure',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('item', TextType::class, [
                'required' => false,
                'label' => 'Ingrédient ou plat',
            ])
            /*            ->add('submit', SubmitType::class, [
                            'label' => 'Recherche',
                            'attr' => [
                                'class' => 'btn btn-success',
                            ],
                        ])*/
            ->add('category', EntityType::class, [
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('diet', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'Végétarien' => 'vegetarian',
                    'Sans gluten' => 'gluten_free',
                    'Végan' => 'vegan',
                    'Halal' => 'halal',
                    'Casher' => 'kosher',
                ],
            ])
//            ->add('diet', Diet::class, [
//                'class' => Diet::class,
//                'choice_label' => 'name',
//                'multiple' => true,
//                'expanded' => true,
//            ])

            ->add('price', IntegerType::class, [
                'required' => false,
                'label' => 'Fourchette de prix',
                'attr' => [
                    'placeholder' => '€€ - €€€',
                ],
            ]);
    }
}
