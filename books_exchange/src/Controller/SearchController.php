<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
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
    public function index(Request $request, BookRepository $bookRepo, CategoryRepository $categoryRepo): Response
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

        /* Full text search part */
        $search = $request->query->get('q');
        $search = trim($search);
        
        $repository = $this->getDoctrine()->getRepository(Book::class);

        $books = $repository->findAll($search);
        
        if ($search === null || $search === '') {
            return $this->redirectToRoute('app_home');
        } else {
            $books = $bookRepo->search(
                $search = $request->query->get('q'),
                $search = $request->query->get('category')
            );
        }
        /* Search, how to add another form in the template for more criteria or alphabetical filtering or date or author etc */

        // We check if we have an ajax request
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('main/_content.html.twig', [
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

        return $this->render('main/search_books_test.html.twig', [
            'books' => $books,
            'category' => $category,
            'limit' => $limit,
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
        ]);
    }
}
