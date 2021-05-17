<?php

namespace App\Security;

use App\Entity\User as AppUser;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class UserChecker implements UserCheckerInterface
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }
        /*
        if ($user->isDeleted()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
        }*/

        if (!$user->isVerified()) {
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@booksexchange.test', 'BooksExchange.test'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre adresse e-mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            throw new CustomUserMessageAccountStatusException('Votre compte n\'est pas activé. Veuillez confirmer 
            votre inscription en cliquant sur le lien qui vous a été envoyé par email. Pensez à vérifier dans vos spams.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }
        /*
        // user account is expired, the user may be notified
        if ($user->isExpired()) {
            throw new AccountExpiredException('...');
        }
        */
    }
}
