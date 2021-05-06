<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/book", name="admin_book_")
 * @package App\Controller\Admin
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BookRepository $bookRepo): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'book' => $bookRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
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

            return $this->redirectToRoute('admin_book_home');
        }

        return $this->render('admin/book/add.html.twig', [
            'addBookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateBook(Book $book, Request $request): Response
    {
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

            $this->addFlash('message', 'Livre mis à jour');
            return $this->redirectToRoute('admin_book_home');
        }

        return $this->render('admin/book/update.html.twig', [
            'updateBookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/add/exchange/{id}/", name="add_exchange")
     */
    public function addExchange(Book $book): Response
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
        return $this->redirectToRoute('admin_book_home');
    }

    /**
     * @Route("/remove/exchange/{id}", name="remove_exchange")
     */
    public function removeExchange(Book $book): Response
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
        return $this->redirectToRoute('admin_book_home');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteBook(Book $book): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash('message', 'Livre supprimé avec succès');
        return $this->redirectToRoute('admin_book_home');
    }
}
