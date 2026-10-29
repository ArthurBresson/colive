<?php

namespace App\Controller\Admin;

use App\Entity\PhotoEspace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PhotoEspaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PhotoEspace::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom du fichier'),
            TextField::new('imgType', 'Type MIME (ex: image/jpeg)'),

            // impossible d'afficher un BLOB
            TextareaField::new('img', 'Données binaires (BLOB)')
                ->hideOnForm()
                ->setHelp('Le contenu binaire ne peut pas être modifié manuellement.'),

            // asso avec espace
            AssociationField::new('espace', 'Espace rattaché')
                ->setFormTypeOption('choice_label', 'titreEsp')
                ->setQueryBuilder(fn ($queryBuilder) => $queryBuilder->orderBy('entity.titreEsp', 'ASC')),
        ];
    }

    public function configureEntity(EntityDto $entityDto): EntityDto
    {
        return $entityDto
            ->setEntityLabelInSingular('Photo d\'un espace')
            ->setEntityLabelInPlural('Photos des espaces');
    }
}
