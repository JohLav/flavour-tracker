<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('items', ItemAutocompleteField::class, [
                'placeholder' => 'Quoi ?',
                'attr' => [
                    'class' => 'mt-4'
                ],
            ])
            ->add('city', CityAutocompleteField::class, [
                'placeholder' => 'Où ?',
                'attr' => [
                    'class' => 'mt-4'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
