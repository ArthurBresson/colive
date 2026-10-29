<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    // pour garder le mdp hashé
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('nomUtil', 'Nom'),
            TextField::new('prenomUtil', 'Prénom'),

            // le choix des roles
            ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ])
                ->allowMultipleChoices()
                ->renderAsBadges(),

            // le mdp
            TextField::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()
                ->setRequired(Crud::PAGE_NEW === $pageName)
                ->setHelp('Laissez vide pour ne pas modifier le mot de passe actuel'),

            TextField::new('villeUtil', 'Ville'),
            TextField::new('cpUtil', 'Code Postal'),
            TextField::new('adresseUtil', 'Adresse'),
        ];
    }

    // à la création
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->hashPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    // à la modification
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $plainPassword = $entityInstance->getPassword();

        if (null === $plainPassword || '' === $plainPassword) {
            // si vide: on récup ancien mdp hashé
            $uow = $entityManager->getUnitOfWork();
            $originalData = $uow->getOriginalEntityData($entityInstance);
            $entityInstance->setPassword($originalData['password']);
        } else {
            // si rempli: on hashe
            $this->hashPassword($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function hashPassword(Utilisateur $user): void
    {
        $plainPassword = $user->getPassword();

        // on hache que si ce n'est pas vide
        if (!empty($plainPassword)) {
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $plainPassword)
            );
        }
    }
}
