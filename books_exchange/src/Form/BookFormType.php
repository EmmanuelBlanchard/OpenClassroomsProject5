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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('author', EntityType::class, [
                'class' => Author::class
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class
            ])
            ->add('publisher', EntityType::class, [
                'class' => Publisher::class
            ])
            ->add('summary', TextareaType::class)
            ->add('language', EntityType::class, [
                'class' => Language::class
            ])
            ->add('format', EntityType::class, [
                'class' => Format::class
            ])
            ->add('state', EntityType::class, [
                'class' => State::class
            ])
            ->add('validate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
