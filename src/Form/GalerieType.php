<?php

namespace App\Form;

use App\Entity\Galerie;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];   // passed from controller
        $collection = $user?->getCollectionVoitures();
        
        $builder
        ->add('description')
        ->add('publiee', CheckboxType::class, [
            'required' => false,
        ])
        ->add('voitures', EntityType::class, [
            'class' => Voiture::class,
            'choice_label' => fn (Voiture $v) =>
            $v->getMarque() .' '. $v->getModele().' ('.$v->getAnnee().')',
            'multiple' => true,
            'expanded' => true,
            
            // 🟢 FILTER: Only show user's cars
            'query_builder' => function (VoitureRepository $repo) use ($collection) {
            return $repo->createQueryBuilder('v')
            ->andWhere('v.collectionVoitures = :col')
            ->setParameter('col', $collection);
            },
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Galerie::class,
            'user' => null,
        ]);
    }
}
