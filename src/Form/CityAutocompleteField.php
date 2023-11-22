<?php

    namespace App\Form;

    use App\Entity\City;
    use App\Repository\CityRepository;
    use Symfony\Component\Form\AbstractType;
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
            'required' => false,
            'searchable_fields' => ['name'],
            'placeholder' => 'Ville',
            'label' => false,
            'choice_label' => function (City $city) {
                return $city->getRealName() . ' (' . $city->getZipCode() . ')';
            },
            'query_builder' =>
                function (CityRepository $cityRepository) {
                    return $cityRepository->createQueryBuilder('city');
                },
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
