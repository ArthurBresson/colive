<?php

namespace App\Controller\Admin;

use App\Entity\Conversation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ConversationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conversation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
        ];
    }

    public function configureEntity(EntityDto $entityDto): EntityDto
    {
        return $entityDto
            ->setEntityLabelInSingular('Conversation')
            ->setEntityLabelInPlural('Conversations');
    }
}
