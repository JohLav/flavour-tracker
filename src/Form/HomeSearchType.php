<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', CityAutocompleteField::class, [
                'required' => false,
                'class' => City::class,
                'placeholder' => 'Ou ?',
                'attr' => [
                    'class' => 'mt-4'
                ],
                'label' => false,
            ])
            ->add('items', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'autocomplete' => true,
                'attr' => [
                    'placeholder' => 'Quoi ?',
                ],
                'tom_select_options' => [
                    'create' => true
                ],
                'choice_label' => 'name',
                'choices' => []
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $form = $event->getForm();

            $form->add('items', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'autocomplete' => true,
                'attr' => [
                    'placeholder' => 'Quoi ?',
                ],
                'tom_select_options' => [
                    'create' => true
                ],
                'choice_label' => 'name',
                'choices' => array_combine($options['data']['items'], $options['data']['items']),
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
