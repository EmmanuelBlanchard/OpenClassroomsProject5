<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditEmailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir une adresse e-mail',
                        ]),
                        new Email([
                            'message' => 'L\'e-mail \'{{ value }}\' n\'est pas un e-mail valide.',
                            'mode' => 'loose',
                        ]),
                        new Regex([
                            'pattern' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
                            'match' => true,
                            'message' => 'Votre adresse e-mail doit comporter au moins une arobase, un caractère point puis au minimun deux caractères',
                        ]),
                    ],
                    'label' => 'Nouvelle adresse e-mail',
                    'required' => true,
                ],
                'second_options' => [
                    'label' => 'Répéter l\'adresse e-mail',
                ],
                'invalid_message' => 'Les champs de l\'adresse e-mail doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'E-mail',
            ])
            ->add('validate', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success btn-lg'],
                'label' => 'Valider',
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
