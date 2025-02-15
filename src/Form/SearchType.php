<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Diet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', CityAutocompleteField::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Ville'],
                'row_attr' => ['class' => 'm-1']
            ])
            ->add('timeSlot', DateTimeType::class, [
                'required' => false,
                'label' => false,
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Date'],
                'row_attr' => ['class' => 'm-1']
            ])
            ->add('category', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => ['placeholder' => 'Catégorie'],
                'row_attr' => ['class' => 'm-1']
            ])
            ->add('diets', EntityType::class, [
                'required' => false,
                'label' => false,
                'mapped' => false,
                'class' => Diet::class,
                'choice_label' => 'name',
                'multiple' => true,
                'autocomplete' => true,
                'attr' => ['placeholder' => 'Alimentation'],
                'row_attr' => ['class' => 'm-1'],
            ])
            ->add('price', RangeType::class, [
                'required' => false,
                'label' => 'Prix maximum',
                'attr' => [
                    'min' => 1,
                    'max' => 100
                ],
                'label_attr' => [
                    'id' => 'container_price',
                    'class' => 'm-0'
                ],
                'row_attr' => ['class' => 'm-1'],
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            if (!isset($data['items'])) {
                $data['items'] = [];
            }

            $form->add('items', ItemAutocompleteField::class, [
                'data' => $data['items'] ?? null,
//                'required' => false,
//                'label' => false,
//                'attr' => ['placeholder' => 'Plats, boissons'],
//                'multiple' => true,
//                'autocomplete' => true,
//                'tom_select_options' => ['create' => true],
//                'choices' => array_combine(
//                    $options['data']['items'] ?? [],
//                    $options['data']['items'] ?? []
//                ),
//                'row_attr' => ['class' => 'm-1'],
            ]);
        });
    }
}
