<?php

namespace App\Form;

use App\Entity\CollectionVoitures;
use App\Entity\Galerie;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modele')
            ->add('marque')
            ->add('annee')
            ->add('collectionVoitures', EntityType::class, [
                'class' => CollectionVoitures::class,
                'choice_label' => 'id',
            ])
            ->add('galeries', EntityType::class, [
                'class' => Galerie::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
