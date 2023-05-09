<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Diet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('city', CityAutocompleteField::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                'row_attr' => [
                    'class' => 'm-1',
                ]
            ])
            ->add('timeSlot', DateTimeType::class, [
                'required' => false,
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                'row_attr' => [
                    'class' => 'm-1',
                ]
            ])
            ->add('items', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'multiple' => true,
                'autocomplete' => true,
                'attr' => ['placeholder' => 'Ingrédient ou plat'],
                'tom_select_options' => [
                    'create' => true
                ],
                'row_attr' => [
                    'class' => 'm-1',
                ],
                'choices' => []
            ])
            ->add('category', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Catégorie',
                'row_attr' => [
                    'class' => 'm-1',
                ]
            ])
            ->add('diets', EntityType::class, [
                'required' => false,
                'label' => false,
                'mapped' => false,
                'class' => Diet::class,
                'choice_label' => 'name',
                'multiple' => true,
                'autocomplete' => true,
                'attr' => ['placeholder' => 'Diets'],
                'row_attr' => [
                    'class' => 'm-1',
                ],
            ])
            ->add('price', RangeType::class, [
                'required' => false,
                'label' => '50 €',
                'attr' => [
                    'min' => 1,
                    'max' => 100
                ],
                'label_attr' => [
                    'id' => 'container_price',
                    'class' => 'm-0'
                ],
                'row_attr' => [
                    'class' => 'm-1',

                ],
            ]);


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $form = $event->getForm();

            $form->add('items', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Ingrédient ou plat'],
                'multiple' => true,
                'autocomplete' => true,
                'tom_select_options' => [
                    'create' => true
                ],
                'choices' => array_combine($options['data']['items'], $options['data']['items']),
                'row_attr' => [
                    'class' => 'm-1',
                ],
            ]);
        });
    }
}
