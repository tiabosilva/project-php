<?php

namespace App\Controller\Admin;

use App\Entity\CollectionVoitures;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CollectionVoituresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CollectionVoitures::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom de la collection'),
            TextEditorField::new('description'),
            IntegerField::new('yearCreated', 'Année de création'),
        ];
    }
}
