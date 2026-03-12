<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;




class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom Complet',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Saisissez le nom...'
                ],
            ])
           ->add('email', EmailType::class, [ 
                'label' => 'Adresse Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'exemple@iset.tn'
                ],
            ])
            ->add('niveau', TextType::class, [
                'label' => 'Niveau du etudes',  
                'attr' => ['class' => 'form-select', 'placeholder' => 'niveau' ]
                 ])
          ->add('projets', EntityType::class, [
                'class' => Projet::class,
                'label' => 'Choisir les projets',
                'choice_label' => 'titre',
                'multiple' => true,   
                'expanded' => true,   
                'attr' => ['class' => 'form-check'],
            ])
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
