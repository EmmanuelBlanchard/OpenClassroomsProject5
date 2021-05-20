<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(Request $request, BookRepository $bookRepo): Response
    {
        $search = $request->query->get('q');
        $search = trim($search);
        
        $repository = $this->getDoctrine()->getRepository(Book::class);

        $books = $repository->findAll($search);

        //$search = $request->query->get('q');
        //dd($books);

        if ($search === null || $search === '') {
            return $this->redirectToRoute('app_home');
        } else {
            $books = $bookRepo->search(
                $search = $request->query->get('q'),
                $search = $request->query->get('category')
            );
        }

        return $this->render('main/search_books_test.html.twig', [
            'books' => $books,
        ]);
    }
}
