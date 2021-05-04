<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function index(BookRepository $bookRepo): Response
    {
        $user = $this->getUser();
        $books = $bookRepo->findBooksActiveOwnedByUserWithOrderCreatedAtDesc($user);
        return $this->render('book/index.html.twig', [
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
    public function show($slug, BookRepository $bookRepo): Response
    {
        $book = $bookRepo->findOneBy(['slug' => $slug]);

        if(!$book) {
            throw new NotFoundHttpException('Pas de livre trouvé');
        }

        return $this->render('book/show.html.twig', compact('book'));
    }

    /**
     * @Route("/remove/stock/{id}", name="remove_stock")
     */
    public function removeStock(Book $book): Response
    {
        if($book === null) {
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
     * @Route("/add/exchanges/{id}", name="add_exchanges")
     */
    public function addExchanges(Book $book): Response
    {
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
        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/remove/exchanges/{id}", name="remove_exchanges")
     */
    public function removeExchanges(Book $book): Response
    {
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
        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/exchanges", name="exchanges")
     */
    public function exchanges(BookRepository $bookRepo): Response
    {
        $user = $this->getUser();

        $theBooksIRequestedToExchange = $bookRepo->findBooksActiveWithExchangeRequestRequestedByUser($user);

        $myBooksRequestedForExchange  = $bookRepo->findBooksActiveWithExchangeRequestOwnedByUser($user);

        return $this->render('book/exchanges.html.twig', ['theBooksIRequestedToExchange' => $theBooksIRequestedToExchange,'myBooksRequestedForExchange' => $myBooksRequestedForExchange]);
    }

}
