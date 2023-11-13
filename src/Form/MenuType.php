<?php

    namespace App\Form;

    use App\Entity\Diet;
    use App\Entity\Item;
    use App\Entity\Menu;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Menu du midi'
                ],
                'row_attr' => [
                    'class' => "form-floating",
                ],
                'required' => true,
                'help' => 'Saisir le titre de votre menu.',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Tous les jours de la semaine de 12h à 14h.'
                ],
                'required' => false,
                'help' => 'Saisir la description de votre menu.',
            ])
            ->add('reduction', NumberType::class, [
                'label' => 'Promotion',
                'attr' => [
                    'placeholder' => '20'
                ],
                'required' => true,
                'help' => 'Saisir la réduction en pourcentage, par exemple 15,55%',
            ])
            ->add('diets', EntityType::class, [
                'class' => Diet::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Régime alimentaire',
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
                'required' => true,
                'help' => 'Sélectionner le(s) régime(s) alimentaire(s) qui correspondent à votre menu.',
            ])
            ->add('items', EntityType::class, [
                'label' => 'Plats',
                'class' => Item::class,
                'choice_label' => 'name',
                'multiple' => true,
                'autocomplete' => true,
                'required' => true,
                'help' => 'Sélectionner les plats qui composent votre menu.',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'row_attr' => [
                    'class' => "btn-secondary",
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
