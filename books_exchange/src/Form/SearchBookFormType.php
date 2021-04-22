<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchBookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('words', SearchType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control me-2',
                    'placeholder' => 'Rechercher',
                    'aria-label' => 'Rechercher',
                ],
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Toutes les catégories',
                    'aria-label' => 'Toutes les catégories',
                ],
                'required' => false
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-outline-orange',
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
