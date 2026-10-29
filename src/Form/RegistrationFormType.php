<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['class' => 'form-control colive-input']])
            ->add('prenomUtil', TextType::class, ['label' => 'Prénom', 'attr' => ['class' => 'form-control colive-input']])
            ->add('nomUtil', TextType::class, ['label' => 'Nom', 'attr' => ['class' => 'form-control colive-input']])
            ->add('adresseUtil', TextType::class, ['label' => 'Adresse', 'attr' => ['class' => 'form-control colive-input']])
            ->add('cpUtil', TextType::class, ['label' => 'Code Postal', 'attr' => ['class' => 'form-control colive-input']])
            ->add('villeUtil', TextType::class, ['label' => 'Ville', 'attr' => ['class' => 'form-control colive-input']])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'form-control colive-input', 'autocomplete' => 'new-password']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
