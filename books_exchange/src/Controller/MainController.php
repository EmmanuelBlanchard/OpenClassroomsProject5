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
    public function index(Request $request, BookRepository $bookRepo): Response
    {
        // We define the number of books per page
        $limit = 10;
        // We get the page number
        $page = (int)$request->query->get("page", 1);
        // We get the books of the page according to the filter
        $books = $bookRepo->getPaginatedBooksNoUser($page, $limit);
        // We get the total number of books according to the filter
        $total = $bookRepo->getTotalBooksActiveWithoutExchangeRequest();
        // How many pages will there be
        $pages = ceil($total / $limit);

        if ($this->getUser()) {
            // We get the information of the connected user
            $user = $this->getUser();
            // We define the number of books per page
            $limit = 10;
            // We get the page number
            $page = (int)$request->query->get("page", 1);
            // We get the books of the page according to the filter
            $books = $bookRepo->getPaginatedBooks($page, $limit, $user);
            // We get the total number of books according to the filter
            $total = $bookRepo->getTotalBooksActiveWithoutExchangeRequestNotOwnedByUser($user);
            // How many pages will there be
            $pages = ceil($total / $limit);

            return $this->render('main/index.html.twig', [
                'books' => $books,
                'limit' => $limit,
                'page' => $page,
                'pages' => $pages,
                'total' => $total,
            ]);
        }

        return $this->render('main/index.html.twig', [
            'books' => $books,
            'limit' => $limit,
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
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
