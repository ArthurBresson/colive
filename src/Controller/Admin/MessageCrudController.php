<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class MessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Message::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextareaField::new('content', 'Contenu du message'),
            DateTimeField::new('createdAt', 'Envoyé le'),

            // asso avec conversation
            AssociationField::new('conversation', 'Conversation')
                ->setFormTypeOption('choice_label', 'id')
                ->setQueryBuilder(fn ($queryBuilder) => $queryBuilder->orderBy('entity.id', 'ASC')), ];
    }

    public function configureEntity(EntityDto $entityDto): EntityDto
    {
        return $entityDto
            ->setEntityLabelInSingular('Message')
            ->setEntityLabelInPlural('Messages');
    }
}
