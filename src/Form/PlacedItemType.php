<?php

namespace App\Form;

use App\Entity\ItemCatalog;
use App\Entity\PlacedItem;
use App\Entity\Plan;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlacedItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('x')
            ->add('y')
            ->add('rotation')
            ->add('currentWidth')
            ->add('currentHeight')
            ->add('plan', EntityType::class, [
                'class' => Plan::class,
                'choice_label' => 'id',
            ])
            ->add('catalogItem', EntityType::class, [
                'class' => ItemCatalog::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlacedItem::class,
        ]);
    }
}
