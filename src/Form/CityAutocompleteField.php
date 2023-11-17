<?php

    namespace App\Form;

    use App\Entity\City;
    use App\Repository\CityRepository;
    use Doctrine\ORM\EntityRepository;
    use Doctrine\ORM\QueryBuilder;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
    use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

    #[AsEntityAutocompleteField]
class CityAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => City::class,
            'placeholder' => 'Ville',
            'choice_label' => function (City $city) {
                return $city->getRealName() . ' (' . $city->getZipCode() . ')';
            },
//            'searchable_fields' => [
//                'name',
//                'zipCode'
//            ],
            'query_builder' =>
                function (CityRepository $cityRepository) {
                    return $cityRepository->createQueryBuilder('city');
                },
            function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.city', 'ASC');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
