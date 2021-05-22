<?php

namespace App\Controller;

use App\Form\SearchBookFormType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, BookRepository $bookRepo, CategoryRepository $categoryRepo): Response
    {
        $user = $this->getUser();
        $books = $bookRepo->findBooksActiveWithoutExchangeRequestNotOwnedByUser($user);

        if (!$user) {
            // We define the number of books per page
            $limit = 10;
            // We get the page number
            $page = (int)$request->query->get("page", 1);
            // We recover the filters
            $filters = $request->get("category");
            // We get the books of the page according to the filter
            $books = $bookRepo->getPaginatedBooksNoUser($page, $limit, $filters);
            // We get the total number of books according to the filter
            $total = $bookRepo->getTotalBooksActiveWithoutExchangeRequest($user, $filters);
            // How many pages will there be
            $pages = ceil($total / $limit);

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

        

        return $this->render('main/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/howitworks", name="how_it_works")
     */
    public function howItWorks(): Response
    {
        return $this->render('main/howitworks.html.twig');
    }
}
