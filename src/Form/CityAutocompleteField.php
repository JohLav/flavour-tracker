<?php

    namespace App\Form;

    use App\Entity\City;
    use App\Repository\CityRepository;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
    use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

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
            'query_builder' => function (CityRepository $cityRepository) {
                return $cityRepository->createQueryBuilder('city');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
