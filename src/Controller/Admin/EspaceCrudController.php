<?php

namespace App\Controller\Admin;

use App\Entity\Espace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EspaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Espace::class;
    }

    public function configureEntity(EntityDto $entityDto): EntityDto
    {
        return $entityDto
            ->setEntityLabelInSingular('Espace')
            ->setEntityLabelInPlural('Espaces');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titreEsp', 'Titre de l\'annonce'),
            TextareaField::new('descEsp', 'Description complète'),
            TextField::new('adresseEsp', 'Adresse'),
            TextField::new('villeEsp', 'Ville'),
            TextField::new('cpEsp', 'Code Postal'),
            NumberField::new('surface', 'Surface (m²)'),
            IntegerField::new('tarif', 'Loyer (€)'),
            IntegerField::new('nbMaxColocEsp', 'Nb max colocataires'),
            DateTimeField::new('datePubliEsp', 'Date de publication')->hideOnForm(),
            DateField::new('availableFromEsp', 'Disponible du'),
            DateField::new('availableToEsp', 'au'),

            // asso typeEspace
            AssociationField::new('typeEspace', 'Type d\'espace')
                ->setFormTypeOption('choice_label', 'tpEspLib'),

            // le proprio
            AssociationField::new('owner', 'Propriétaire')
                ->setFormTypeOption('choice_label', 'nomUtil'),

            // asso commodite
            AssociationField::new('commodites', 'Équipements inclus')
                ->setFormTypeOption('choice_label', 'nom_com'),

            // asso photoEspace (on affiche juste le compte)
            AssociationField::new('photoEspaces', 'Nombre de photos')->hideOnForm(),
        ];
    }
}
