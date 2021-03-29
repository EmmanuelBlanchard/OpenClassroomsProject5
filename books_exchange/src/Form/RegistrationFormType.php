<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label'=>'Pseudo',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
            ])
            ->add('zipCode', IntegerType::class, [
                'label' => 'Code Postal',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
                'label' => 'Vous acceptez les conditions générales d\'utilisation
                et la politique de confidentialité du site ÉchangeLivres.',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 12,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                        'maxMessage' => 'Votre mot de passe ne peut pas comporter plus de {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.+[A-Z])(?=.+[a-z])(?=.+\d)(?=.+[-?+!*$@%_&~`\\^\|\#{}()\[\]])([-?+!*$@%_&~`\\\|\#{}()\[\]\w]{12,})$/',
                        'match' => true,
                        'message' => 'Votre mot de passe doit comporter au moins une lettre minuscule, une lettre majuscule, un chiffre, un caractère spécial et 12 caractères minimun',
                    ])
                ],
                'label' => 'Mot de passe',
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success btn-lg'],
                'label' => 'S\'inscrire',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
