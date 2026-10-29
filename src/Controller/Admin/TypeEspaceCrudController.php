<?php

namespace App\Controller\Admin;

use App\Entity\TypeEspace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeEspaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeEspace::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('cdTpEspace', 'Code du type d\'espace'),
            TextField::new('tpEspLib', 'Libellé'),

            // le nb d'espaces qui ont ce type
            AssociationField::new('espaces', 'Nombre d\'espaces liés')
                ->onlyOnIndex(),
        ];
    }

    public function configureEntity(EntityDto $entityDto): EntityDto
    {
        return $entityDto
            ->setEntityLabelInSingular('Type d\'un espace')
            ->setEntityLabelInPlural('Types d\'un espaces');
    }
}
