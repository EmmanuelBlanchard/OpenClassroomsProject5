<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\State;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Publisher;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdvancedSearchBookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Auteur',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false
            ])
            ->add('format', EntityType::class, [
                'class' => Format::class,
                'choice_label' => 'name',
                'label' => 'Format',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'label' => 'Langue',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false
            ])
            ->add('publisher', EntityType::class, [
                'class' => Publisher::class,
                'choice_label' => 'name',
                'label' => 'Éditeur',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false
            ])
            ->add('state', EntityType::class, [
                'class' => State::class,
                'choice_label' => 'name',
                'label' => 'État',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-outline-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
