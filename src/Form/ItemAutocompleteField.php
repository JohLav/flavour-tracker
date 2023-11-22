<?php

    namespace App\Form;

    use App\Entity\Item;
    use App\Repository\ItemRepository;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
    use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

    #[AsEntityAutocompleteField]
class ItemAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Item::class,
            'required' => false,
            'searchable_fields' => ['name'],
            'multiple' => true,
            'label' => false,
            'choice_label' => 'name'
//            'choice_label' => function (Item $item) {
//                return $item->getName();
//            },
//            'query_builder' => function (ItemRepository $itemRepository) {
//                return $itemRepository->createQueryBuilder('name');
//            }
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
