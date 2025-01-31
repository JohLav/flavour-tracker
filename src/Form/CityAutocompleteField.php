<?php

namespace App\Form;

use App\Entity\City;
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
            'searchable_fields' => ['realName'],
            'multiple' => true,
            'label' => false,
            'choice_label' => function (City $city) {
                return $city->getRealName() . ' (' . $city->getZipCode() . ')';
            },
            'tom_select_options' => [
                'placeholder' => 'Où ?',
                'allowEmptyOption' => true,
            ]
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
