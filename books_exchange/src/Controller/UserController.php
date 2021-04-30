<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Form\UpdateEmailFormType;
use App\Repository\BookRepository;
use App\Form\UpdateProfileFormType;
use App\Form\UpdatePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
    * @Route("/user/book", name="user_book")
    */
    public function indexBook(): Response
    {
        return $this->render('user/book/index.html.twig');
    }

    /**
     * @Route("/user/book/add", name="user_book_add")
     */
    public function addBook(Request $request): Response
    {
        $book = new Book;
        $form = $this->createForm(BookFormType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setUser($this->getUser());
            $book->setActive(true);
            $book->setExchangeRequest(false);
            $book->setExchangeRequestAt(new \DateTime('0000-00-00 00:00:00'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('message', 'Le livre a été ajouté à votre stock !');
            return $this->redirectToRoute('user');
        }

        return $this->render('user/book/add.html.twig', [
            'addbookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/book/{id}/remove/stock", name="user_book_remove_stock")
     */
    public function bookRemoveFromStock(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);
        if($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre supprimé du stock de livres');
        }
        return $this->redirectToRoute('user_book');
    }

    /**
     * @Route("/user/book/{id}/add/exchanges", name="user_book_add_exchanges")
     */
    public function bookAddFromExchanges(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);
        if($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $book->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre ajouté aux échanges');
        }
        return $this->redirectToRoute('user_book');
    }

    /**
     * @Route("/user/book/{id}/remove/exchanges", name="user_book_remove_exchanges")
     */
    public function bookRemovedFromExchanges(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);
        if($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $book->setActive(false);
            $book->setExchangeRequest(false);
            $book->setUserexchange(null);
            $book->setExchangeRequestAt(new \DateTime('0000-00-00 00:00:00'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre retiré des échanges');
        }
        return $this->redirectToRoute('user_book');
    }

    /**
     * @Route("/user/book/show/exchange", name="user_book_show_exchange")
     */
    public function showBooksExchange(BookRepository $bookRepo): Response
    {
        $user = $this->getUser();

        $theBooksIRequestedToExchange = $bookRepo->findBooksActiveWithExchangeRequestRequestedByUser($user);

        $myBooksRequestedForExchange  = $bookRepo->findBooksActiveWithExchangeRequestOwnedByUser($user);

        return $this->render('user/book/showexchange.html.twig', ['theBooksIRequestedToExchange' => $theBooksIRequestedToExchange,'myBooksRequestedForExchange' => $myBooksRequestedForExchange]);
    }

    /**
     * @Route("/user/book/{id}/validation/confirm/exchange", name="user_book_validation_confirm_exchange")
     */
    public function validationConfirmBookExchange(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);
        if($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : problème d\'identification du livre');
        } else {
            return $this->render('user/book/validationconfirmbookexchange.html.twig', ['book' => $book]);
        }
        return $this->redirectToRoute('user_book');
    }

    /**
     * @Route("/user/book/{id}/confirm/exchange", name="user_book_confirm_exchange")
     */
    public function confirmBookExchange(int $id): Response
    {
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);
        if($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : problème d\'identification du livre');
        } else {
            $book->setExchangeRequest(true);
            $book->setExchangeRequestAt(new \DateTime('now'));
            $book->setUserexchange($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->render('user/book/confirmbookexchange.html.twig', ['book' => $book]);
        }
        return $this->redirectToRoute('user_book');
    }

    /**
     * @Route("/user/book/{id}/cancel/exchange", name="user_book_cancel_exchange")
     */
    public function bookCancelExchange(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);
        if($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $book->setActive(false);
            $book->setExchangeRequest(false);
            $book->setUserexchange(null);
            $book->setExchangeRequestAt(new \DateTime('0000-00-00 00:00:00'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre retiré de l\'échange de livres');
        }
        return $this->redirectToRoute('user_book');
    }

    /**
     * @Route("/user/profile/update", name="user_profile_update")
     */
    public function updateProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdateProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/updateprofile.html.twig', [
            'updateProfileForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/password/update", name="user_password_update")
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Mot de passe mis à jour avec succès');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/updatepassword.html.twig', [
            'updatePasswordForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/email/update", name="user_email_update")
     */
    public function updateEmail(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdateEmailFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setEmail (
                $form->get('email')->getData()
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'L\'adresse e-mail a été mise à jour avec succès');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/updateemail.html.twig', [
            'updateEmailForm' => $form->createView()
        ]);
    }

}
