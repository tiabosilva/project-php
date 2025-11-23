<?php

namespace App\Form;

use App\Entity\Galerie;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => false,
            'attr' => [
                'class' => 'form-control mb-3',
                'placeholder' => 'Entrez une description...'
            ],
        ])
        ->add('publiee', CheckboxType::class, [
            'label' => 'Galerie publique ?',
            'required' => false,
            'attr' => ['class' => 'form-check-input me-2'],
        ])
        ->add('voitures', EntityType::class, [
            'class' => Voiture::class,
            'choices' => $options['voitures'],
            'multiple' => true,
            'expanded' => true,
            'label' => 'Choisissez les voitures à ajouter :',
            'choice_label' => function (Voiture $v) {
            return sprintf('%s %s (%s)', $v->getMarque(), $v->getModele(), $v->getAnnee());
            },
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Galerie::class,
            'voitures' => [],
        ]);
    }
}
