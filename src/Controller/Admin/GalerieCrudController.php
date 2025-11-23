<?php

namespace App\Controller\Admin;

use App\Entity\Galerie;
use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GalerieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Galerie::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            
            TextField::new('description', 'Description'),
            BooleanField::new('publiee', 'Publique'),
            
            // FIX HERE → tell EasyAdmin how to show a Member
            AssociationField::new('createur', 'Créateur')
            ->setFormTypeOption('choice_label', function (Member $m) {
                return explode('@', $m->getEmail())[0];
            })
            ->setRequired(false),
            
            // show voitures but not editable
            AssociationField::new('voitures')
            ->onlyOnDetail()
            ->setTemplatePath('admin/fields/voitures_list.html.twig'),
            ];
    }
}
