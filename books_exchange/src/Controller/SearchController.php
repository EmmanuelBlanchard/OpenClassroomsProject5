<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(Request $request, BookRepository $bookRepo): Response
    {
        // We define the number of books per page
        $limit = 5;
        // We get the page number
        $page = (int)$request->query->get("page", 1);

        $search = $request->get('search');

        $search = trim($search);
        if ($search === null || $search === '') {
            return $this->redirectToRoute('app_home');
        }
        $books = $bookRepo->search($search);
        
        if ($request->query->get('ajax')) {
            return $this->render('main/_search_content.html.twig', [
                'books' => $books
            ]);
        }

        return $this->render('main/search_books.html.twig', [
            'books' => $books,
            'search' => $search
        ]);
        
        //dd($search);
    }
}
