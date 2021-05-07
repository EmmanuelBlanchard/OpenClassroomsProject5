<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Form\BookContactFormType;
use App\Repository\BookRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @Route("/book", name="book_")
 * @package App\Controller
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BookRepository $bookRepo, Request $request): Response
    {
        // We get the information of the connected user
        $user = $this->getUser();
        // We define the number of elements per page
        $limit = 10;
        // We get the page number
        $page = (int)$request->query->get("page", 1);
        // We recover the books of the page
        $books = $bookRepo->getPaginatedBooks($page, $limit, $user);
        // We get the total number of books
        $total = $bookRepo->getTotalBooksActiveWithoutExchangeRequestNotOwnedByUser($user);

        return $this->render('book/index.html.twig', compact('books', 'limit', 'page', 'total'));
    }
    
    /**
    * @Route("/stock", name="stock")
    */
    public function stock(BookRepository $bookRepo): Response
    {
        $user = $this->getUser();
        $books = $bookRepo->findBooksActiveOwnedByUserWithOrderCreatedAtDesc($user);
        return $this->render('book/stock.html.twig', [
            'books' => $books]);
    }

    /**
    * @Route("/add", name="add")
    */
    public function add(Request $request): Response
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
            return $this->redirectToRoute('book_home');
        }

        return $this->render('book/add.html.twig', [
            'addBookForm' => $form->createView()
        ]);
    }

    /**
    * @Route("/show/{slug}", name="show")
    */
    public function show($slug, BookRepository $bookRepo, Request $request, MailerInterface $mailer): Response
    {
        $book = $bookRepo->findOneBy(['slug' => $slug]);

        if (!$book) {
            throw new NotFoundHttpException('Pas de livre trouvé');
        }

        $form = $this->createForm(BookContactFormType::class);

        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We create the mail
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($book->getUser()->getEmail())
                ->subject('Contact au sujet de votre livre "' . $book->getTitle() . '"')
                // path of the Twig template to render
                ->htmlTemplate('emails/contact_book.html.twig')
                // pass variables (name => value) to the template
                ->context([
                    'book' => $book,
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            // We send the mail
            $mailer->send($email);

            // We confirm and we redirect
            $this->addFlash('success', 'Votre e-mail a bien été envoyé');
            return $this->redirectToRoute('book_show', ['slug' => $book->getSlug()]);
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'contactBookForm' => $form->createView()
        ]);
    }

    /**
    * @Route("/remove/stock/{id}", name="remove_stock")
    */
    public function removeStock(Book $book): Response
    {
        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre supprimé du stock de livres');
        }
        return $this->redirectToRoute('book_home');
    }

    /**
    * @Route("/exchanges", name="exchanges")
    */
    public function exchanges(BookRepository $bookRepo, Request $request, MailerInterface $mailer): Response
    {
        $user = $this->getUser();

        $theBooksIRequestedToExchange = $bookRepo->findBooksActiveWithExchangeRequestRequestedByUser($user);

        $myBooksRequestedForExchange  = $bookRepo->findBooksActiveWithExchangeRequestOwnedByUser($user);

        if (!$myBooksRequestedForExchange) {
            throw new NotFoundHttpException("Aucun de mes livres demandés");
        }
        
        $form = $this->createForm(BookContactFormType::class);

        $contact = $form->handleRequest($request);
        /*
        if($form->isSubmitted() && $form->isValid()) {
            // We create the mail
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($book->getUser()->getEmail())
                ->subject('Contact au sujet de votre livre "' . $book->getTitle() . '"')
                // path of the Twig template to render
                ->htmlTemplate('emails/contact_book.html.twig')
                // pass variables (name => value) to the template
                ->context([
                    'book' => $book,
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            // We send the mail
            $mailer->send($email);

            // We confirm and we redirect
            $this->addFlash('success', 'Votre e-mail a bien été envoyé');
            return $this->redirectToRoute('book_exchanges');
            }
        */
        return $this->render('book/exchanges.html.twig', [
            'theBooksIRequestedToExchange' => $theBooksIRequestedToExchange,
            'myBooksRequestedForExchange' => $myBooksRequestedForExchange,
            'contactBookForm' => $form->createView()
        ]);
    }
    
    /**
    * @Route("/add/exchanges/{id}", name="add_exchanges")
    */
    public function addExchanges(Book $book): Response
    {
        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $book->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre ajouté aux échanges');
        }
        return $this->redirectToRoute('user');
    }

    /**
    * @Route("/remove/exchanges/{id}", name="remove_exchanges")
    */
    public function removeExchanges(Book $book): Response
    {
        if ($book === null) {
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
        return $this->redirectToRoute('user');
    }

    /**
    * @Route("/cancel/exchange/{id}", name="cancel_exchange")
    */
    public function cancelExchange(Book $book): Response
    {
        if ($book === null) {
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
        return $this->redirectToRoute('app_home');
    }

    /**
    * @Route("/validation/confirm/exchange/{id}", name="validation_confirm_exchange")
    */
    public function validationConfirmExchange(Book $book): Response
    {
        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : problème d\'identification du livre');
        } else {
            return $this->render('book/validation_confirm_exchange.html.twig', ['book' => $book]);
        }
        return $this->redirectToRoute('app_home');
    }

    /**
    * @Route("/confirm/exchange/{id}", name="confirm_exchange")
    */
    public function confirmExchange(Book $book): Response
    {
        $user = $this->getUser();

        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : problème d\'identification du livre');
        } else {
            $book->setExchangeRequest(true);
            $book->setExchangeRequestAt(new \DateTime('now'));
            $book->setUserexchange($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->render('book/confirm_exchange.html.twig', ['book' => $book]);
        }
        return $this->redirectToRoute('app_home');
    }
}
