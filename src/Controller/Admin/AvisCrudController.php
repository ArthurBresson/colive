<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AvisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Avis::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('sujet', 'Titre de l\'avis'),
            TextareaField::new('txt', 'Contenu du commentaire'),
            IntegerField::new('note', 'Note (sur 5)'),

            // asso avec utilisateur
            AssociationField::new('userAvis', 'Auteur')
                ->setQueryBuilder(fn ($queryBuilder) => $queryBuilder->orderBy('entity.nomUtil', 'ASC')),

            // asso avec espace
            AssociationField::new('espaceAvis', 'Espace concerné')
                ->setQueryBuilder(fn ($queryBuilder) => $queryBuilder->orderBy('entity.titreEsp', 'ASC')),
        ];
    }

    // pour les traductions, si on suit le 25. du tp
    public function configureEntity(EntityDto $entityDto): EntityDto
    {
        return $entityDto
            ->setEntityLabelInSingular('Avis')
            ->setEntityLabelInPlural('Avis');
    }
}
