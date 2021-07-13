<?php

namespace App\Controller;

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
        $search = $request->get('search');
        $books = null;

        $search = trim($search);
        if (!($search === null || $search === '')) {
            $booksSearch = $bookRepo->search($search);
            $booksSearchAuthor = $bookRepo->searchByAuthor($search);
            $books = array_merge($booksSearch, $booksSearchAuthor);
        } else {
            return $this->redirectToRoute('app_home');
        }
        
        if ($request->query->get('ajax')) {
            return $this->render('main/_search_content_ajax.html.twig', [
                'books' => $books
            ]);
        }

        return $this->render('main/search_books.html.twig', [
            'books' => $books,
            'search' => $search
        ]);
    }
}
