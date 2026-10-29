<?php

namespace App\Form;

use App\Entity\Commodite;
use App\Entity\Espace;
use App\Entity\TypeEspace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EspaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cpEsp', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: 75000',
                    'maxlength' => 5,
                ],
            ])
            ->add('adresseEsp', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: 17 avenue des Champs-Elysées',
                ],
            ])
            ->add('villeEsp', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Paris',
                ],
            ])
            ->add('titreEsp', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Colocation en centre ville',
                ],
            ])
            ->add('surface', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: 9',
                ],
            ])
            ->add('descEsp', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Appartement situé dans le centre ville, idéal pour 3 colocataires',
                    'maxlength' => 250,
                ],
            ])
            ->add('nbMaxColocEsp', NumberType::class, [
                'label' => 'Nombre maximum de colocataires',
                'attr' => [
                    'placeholder' => 'Ex: 3',
                    'min' => 0,
                ],
            ])
            ->add('availableFromEsp')
            ->add('availableToEsp')
            ->add('tarif', NumberType::class, [
                'label' => 'Prix du loyer (€)',
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Ex: 450',
                ],
            ])
            ->add('typeEspace', EntityType::class, [
                'class' => TypeEspace::class,
                'choice_label' => 'tpEspLib',
            ])
            ->add('commodites', EntityType::class, [
                'class' => Commodite::class,
                'choice_label' => 'nomCom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('envoyer', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-success',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Espace::class,
        ]);
    }
}
