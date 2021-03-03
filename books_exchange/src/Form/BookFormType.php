<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\State;
use App\Entity\Author;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Publisher;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('category', Entity::class, [
                'class' => Category::class
            ])
            ->add('publisher', Entity::class, [
                'class' => Publisher::class
            ])
            ->add('language', Entity::class, [
                'class' => Language::class
            ])
            ->add('format', Entity::class, [
                'class' => Format::class
            ])
            ->add('state', Entity::class, [
                'class' => State::class
            ])
            ->add('author', Entity::class, [
                'class' => Author::class
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
