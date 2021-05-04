<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

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
}
