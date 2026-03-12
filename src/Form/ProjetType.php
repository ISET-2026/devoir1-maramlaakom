<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de projet',
                'attr' => [
                    'placeholder' => 'Saisissez le titre...',
                    'class' => 'form-control',
                ],
            ])
          ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'class' => 'form-control',
                ],
            ])  
            ->add('dateDebut' ,DateTimeType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateFin', DateTimeType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'attr' => ['class' => 'form-control'],
                  ])
           ->add('statut', ChoiceType::class, [ 
                'choices' => [
                    'En préparation' => 'En preparation',
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                ],
                'attr' => ['class' => 'form-select',
                 'placeholder' => 'choisi un status ...',]
            ])
            ->add('enseignant', EntityType::class, [
                'class' => Enseignant::class,
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control', 
                'placeholder' => 'Saisissez un enseignant...',]
            ])
            ->add('etudiants', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'nom',
                'multiple' => true, 
    'expanded' => true,
                   'attr' => ['class' => 'form-control', 
                'placeholder' => 'Saisissez un enseignant...',]
            ])
        ;
    }
    



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
