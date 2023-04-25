<?php

    namespace App\Form;

    use App\Entity\Item;
    use App\Entity\Menu;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

class ALaCarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'À la carte'
                ],
                'row_attr' => [
                    'class' => "form-floating",
                ],
                'required' => true,
                'help' => 'Saisir le titre de votre carte.',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Saisir une description.'
                ],
                'row_attr' => [
                    'class' => "form-floating",
                ],
                'required' => false,
                'help' => 'Saisir une description pour votre carte.',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => '12'
                ],
                'row_attr' => [
                    'class' => "form-floating",
                ],
                'required' => true,
                'help' => "Saisir le prix de l'élément à la carte.",
            ])
            ->add('category', TextType::class, [
                'label' => 'Catégorie',
                'attr' => [
                    'placeholder' => 'Entrée'
                ],
                'row_attr' => [
                    'class' => "form-floating",
                ],
                'required' => true,
                'help' => "Saisir la catégorie de l'élément",
            ])

            /** Faire une checkbox type ? */

//            ->add('visible', TextType::class, [
//                'label' => 'Visibilité',
//                'attr' => [
//                    'placeholder' => 'À la carte'
//                ],
//                'row_attr' => [
//                    'class' => "form-floating",
//                ],
//                'required' => false,
//                'help' => 'Saisir le titre de votre carte.',
//            ])

        /** Est-ce utile ? Ou bien, on ne fait que récupérer les menus ?
         *  Ou est-ce inutile ?
         */
//            ->add('menus', EntityType::class, [
//                'label' => 'Menus',
//                'class' => Menu::class,
//                'choice_label' => 'name',
//                'multiple' => true,
//                'attr' => [
//                    'placeholder' => 'Menu du midi'
//                ],
//                'row_attr' => [
//                    'class' => "form-floating",
//                ],
//                'required' => true,
//                'help' => 'Sélectionner le menu relié à cet élément.',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
