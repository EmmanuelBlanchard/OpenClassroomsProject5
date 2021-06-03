<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Service\UploaderHelper;
use App\Form\BookContactFormType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/book", name="book_")
 * @package App\Controller
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BookRepository $bookRepo, CategoryRepository $categoryRepo, Request $request): Response
    {
        // We get the information of the connected user
        $user = $this->getUser();
        // We define the number of books per page
        $limit = 10;
        // We get the page number
        $page = (int)$request->query->get("page", 1);

        // We recover the filters
        $filters = $request->get("category");
        
        // We get the books of the page according to the filter
        $books = $bookRepo->getPaginatedBooks($page, $limit, $user, $filters);
        // We get the total number of books according to the filter
        $total = $bookRepo->getTotalBooksActiveWithoutExchangeRequestNotOwnedByUser($user, $filters);
        // How many pages will there be
        $pages = ceil($total / $limit);

        // We check if we have an ajax request
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('book/_content.html.twig', [
                    'books' => $books,
                    'limit' => $limit,
                    'page' => $page,
                    'pages' => $pages,
                    'total' => $total,
                ])
            ]);
        }

        // We recover all categories
        $category = $categoryRepo->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'category' => $category,
            'limit' => $limit,
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
        ]);
    }
    
    /**
    * @Route("/mybooks", name="my_books")
    */
    public function myBooks(BookRepository $bookRepo, Request $request): Response
    {
        // We get the information of the connected user
        $user = $this->getUser();
        // We define the number of books per page
        $limit = 10;
        // We get the page number
        $page = (int)$request->query->get("page", 1);
        // We recover the books of the page
        $books = $bookRepo->findBooksActiveOwnedByUserWithOrderCreatedAtDesc($page, $limit, $user);
        // We get the total number of books
        $total = $bookRepo->getTotalBooksActiveOwnedByUserWithOrderCreatedAtDesc($user);
        // How many pages will there be
        $pages = (int)ceil($total / $limit);

        return $this->render('book/my_books.html.twig', compact('books', 'limit', 'page', 'pages', 'total'));
    }
    
    /**
    * @Route("/add", name="add")
    */
    public function add(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $book = new Book;
        $form = $this->createForm(BookFormType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadBookImage($uploadedFile);
                $book->setImageFilename($newFilename);
            }
            
            $book->setUser($this->getUser());
            $book->setActive(true);
            $book->setExchangeRequest(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('message', 'Le livre a été ajouté à votre stock !');
            return $this->redirectToRoute('book_my_books');
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
    * @Route("/remove/{id}", name="remove")
    */
    public function remove(Book $book): Response
    {
        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre supprimé avec succès');
        }
        return $this->redirectToRoute('book_home');
    }
    
    /**
    * @Route("/howmakeexchange", name="how_make_exchange")
    */
    public function howMakeExchange(): Response
    {
        return $this->render('book/how_make_exchange.html.twig');
    }

    /**
    * @Route("/myexchangewishes", name="my_exchange_wishes")
    */
    public function myExchangeWishes(BookRepository $bookRepo, UserInterface $user, Request $request): Response
    {
        // We define the number of books per page
        $limit = 10;
        // We get the page number
        $page = (int)$request->query->get("page", 1);
        // We recover the books of the page
        $theBooksIRequestedToExchange = $bookRepo->findBooksActiveWithExchangeRequestRequestedByUser($page, $limit, $user);
        // We get the total number of books
        $total = $bookRepo->getTotalBooksActiveWithExchangeRequestRequestedByUser($user);
        // How many pages will there be
        $pages = (int)ceil($total / $limit);

        return $this->render('book/my_exchange_wishes.html.twig', [
            'theBooksIRequestedToExchange' => $theBooksIRequestedToExchange,
            'limit' => $limit,
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
        ]);
    }

    /**
    * @Route("/myexchangerequests", name="my_exchange_requests")
    */
    public function myExchangeRequests(BookRepository $bookRepo, UserInterface $user, Request $request): Response
    {
        // We define the number of books per page
        $limit = 10;
        // We get the page number
        $page = (int)$request->query->get("page", 1);
        // We recover the books of the page
        $myBooksRequestedForExchange  = $bookRepo->findBooksActiveWithExchangeRequestOwnedByUser($page, $limit, $user);
        // We get the total number of books
        $total = $bookRepo->getTotalBooksActiveWithEchangeRequestOwnedByUser($user);
        // How many pages will there be
        $pages = (int)ceil($total / $limit);

        return $this->render('book/my_exchange_requests.html.twig', [
            'myBooksRequestedForExchange' => $myBooksRequestedForExchange,
            'limit' => $limit,
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
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
        return $this->redirectToRoute('book_my_books');
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
            $book->setExchangeRequestAt(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre retiré des échanges');
        }
        return $this->redirectToRoute('book_my_books');
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
            $book->setActive(true);
            $book->setExchangeRequest(false);
            $book->setUserexchange(null);
            $book->setExchangeRequestAt(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre retiré de l\'échange de livres');
        }
        return $this->redirectToRoute('book_my_exchange_wishes');
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
