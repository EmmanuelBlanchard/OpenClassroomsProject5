<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\State;
use App\Entity\Author;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Publisher;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Titre',
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'label' => 'Auteur',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
            ])
            ->add('publisher', EntityType::class, [
                'class' => Publisher::class,
                'label' => 'Éditeur',
            ])
            ->add('summary', CKEditorType::class, [
                'label' => 'Résumé',
                'config' => [
                'language' => 'fr',
                ],
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'label' => 'Langage',
            ])
            ->add('format', EntityType::class, [
                'class' => Format::class,
                'label' => 'Format',
            ])
            ->add('state', EntityType::class, [
                'class' => State::class,
                'label' => 'État',
            ])
        ;

        $imageConstraints = [
            new Image([
                'maxSize' => '5M'
            ])
        ];
        $builder
            ->add('imageFile', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => $imageConstraints
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
