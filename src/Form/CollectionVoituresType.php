<?php

namespace App\Form;

use App\Entity\CollectionVoitures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CollectionVoituresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom de la collection',
            'required' => true,
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => true,
        ])
        ->add('yearCreated', IntegerType::class, [
            'label' => 'Année de création',
            'required' => true,
        ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CollectionVoitures::class,
        ]);
    }
}
