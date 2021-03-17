<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Form\EditProfileFormType;
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
            $book->setActive(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre retiré du stock de livres');
        }
        return $this->redirectToRoute('user_book');
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
            $book->setActive(false);
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
     * @Route("/user/book/show/exchange", name="user_book_show_exchange")
     */
    public function showBooksExchange(): Response
    {
        $books = $this->getDoctrine()->getRepository(Book::class)->findBy(
            ['exchangeRequest' => true],
            ['exchangeRequestAt' => 'desc']
        );
        
        return $this->render('user/book/showexchange.html.twig', ['books' => $books]);
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
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);
        if($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : problème d\'identification du livre');
        } else {
            $book->setExchangeRequest(true);
            $book->setExchangeRequestAt(new \DateTime('now'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->render('user/book/confirmbookexchange.html.twig', ['book' => $book]);
        }
        return $this->redirectToRoute('user_book');
    }

    /**
     * @Route("/user/profile/edit", name="user_profile_edit")
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/editprofile.html.twig', [
            'editprofileForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/password/edit", name="user_password_edit")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            // We check if the 2 passwords are identical
            if($request->request->get('password') == $request->request->get('password2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
                $entityManager->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');
                return $this->redirectToRoute('user');
            } else {
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }
        return $this->render('user/editpassword.html.twig');
    }

    /**
     * @Route("/user/email/edit", name="user_email_edit")
     */
    public function editEmail(Request $request): Response
    {
        if($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            // We check if the 2 e-mails are identical
            if($request->request->get('email') == $request->request->get('email2')){
                $user->setEmail($request->request->get('email'));
                $entityManager->flush();
                $this->addFlash('message', 'E-mail mis à jour avec succès');
                return $this->redirectToRoute('user');
            } else {
                $this->addFlash('error', 'Les deux e-mail ne sont pas identiques');
            }
        }
        return $this->render('user/editemail.html.twig');
    }

}
