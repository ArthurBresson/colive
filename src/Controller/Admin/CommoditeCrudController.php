<?php

namespace App\Controller\Admin;

use App\Entity\Commodite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommoditeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commodite::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom_com', 'Nom de la commodité'),
        ];
    }

    public function configureEntity(EntityDto $entityDto): EntityDto
    {
        return $entityDto
            ->setEntityLabelInSingular('Commodité')
            ->setEntityLabelInPlural('Commodités');
    }
}
