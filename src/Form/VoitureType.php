<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('marque', TextType::class, [
            'label' => 'Marque',
            'attr' => ['class' => 'form-control mb-3']
        ])
        ->add('modele', TextType::class, [
            'label' => 'Modèle',
            'attr' => ['class' => 'form-control mb-3']
        ])
        ->add('annee', TextType::class, [
            'label' => 'Année',
            'attr' => ['class' => 'form-control mb-3']
        ])
        ->add('imageFile', FileType::class, [
            'label' => 'Photo de la voiture (JPEG/PNG)',
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'form-control mb-3'],
            'constraints' => [
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => ['image/jpeg', 'image/png'],
                    'mimeTypesMessage' => 'Veuillez uploader une image JPEG ou PNG.',
                ])
            ],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
