<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Form\AdvancedSearchBookFormType;
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
        // We define the number of books per page
        $limit = 10;
        // We get the page number
        $page = (int)$request->query->get("page", 1);
        // We recover the filters
        $filters = $request->get("category");
        // We get the books of the page according to the filter
        $books = $bookRepo->getPaginatedBooksNoUser($page, $limit, $filters);
        // We get the total number of books according to the filter
        $total = $bookRepo->getTotalBooksActiveWithoutExchangeRequest($filters);
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

        /* Full text search part */
        $search = $request->query->get('q');
        $search = trim($search);
        
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $books = $repository->findAll($search);
        
        if ($search === null || $search === '') {
            return $this->redirectToRoute('app_home');
        } else {
            $books = $bookRepo->search(
                $page,
                $limit,
                $search = $request->query->get('q'),
                $search = $request->query->get('category')
            );
            // We get the total number of books retrieved by the full text search
            $total = $bookRepo->getTotalNumberBooksInSearch(
                $search = $request->query->get('q'),
                $search = $request->query->get('category')
            );
            // How many pages will there be
            $pages = ceil($total / $limit);
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
        /* Search, how to add another form in the template for more criteria or alphabetical filtering or date or author etc */

        if ($this->getUser()) {
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
                    'content' => $this->renderView('main/_content.html.twig', [
                        'books' => $books,
                        'limit' => $limit,
                        'page' => $page,
                        'pages' => $pages,
                        'total' => $total,
                    ])
                ]);
            }

            /* Full text search part */
            $search = $request->query->get('q');
            $search = trim($search);
        
            $repository = $this->getDoctrine()->getRepository(Book::class);
            $books = $repository->findAll($search);
        
            if ($search === null || $search === '') {
                return $this->redirectToRoute('app_home');
            } else {
                $books = $bookRepo->search(
                    $page,
                    $limit,
                    $search = $request->query->get('q'),
                    $search = $request->query->get('category')
                );
                // We get the total number of books retrieved by the full text search
                $total = $bookRepo->getTotalNumberBooksInSearch(
                    $search = $request->query->get('q'),
                    $search = $request->query->get('category')
                );
                // How many pages will there be
                $pages = ceil($total / $limit);
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
            /* Search, how to add another form in the template for more criteria or alphabetical filtering or date or author etc */

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

    /**
     * @Route("/search/books", name="app_search_books")
     */
    public function searchBook(Request $request, BookRepository $bookRepo): Response
    {
        $searchBookForm = $this->createForm(AdvancedSearchBookFormType::class);

        $repository = $this->getDoctrine()->getRepository(Book::class);
        $books = $repository->findAll();
        //dd($books);
        $searchBookForm->handleRequest($request);

        if ($searchBookForm->isSubmitted() && $searchBookForm->isValid()) {
            // Returns a array
            $author = $searchBookForm->getData("author");
            // Returns null when select a field
            //$author = $request->query->get('category');
            //dd($author);
            
            $category = $searchBookForm->getData('category');
            $format = $searchBookForm->getData('format');
            $language = $searchBookForm->getData('language');
            $publisher = $searchBookForm->getData('publisher');
            $state = $searchBookForm->getData('state');
            //$zipCode = $searchBookForm->getData('zipCode');
            //$city = $searchBookForm->getData('city');
            
            $criteria = $searchBookForm->getData();
            //dd($criteria);
            
            /*
            $books = $bookRepo->searchBook(
                $author,
                $category,
                $format,
                $language,
                $publisher,
                $state
            );
            */
            
            $books = $bookRepo->searchBook(
                $author = $request->query->get("author"),
                $category = $request->query->get("category"),
                $format = $request->query->get("format"),
                $language = $request->query->get("language"),
                $publisher = $request->query->get("publisher"),
                $state = $request->query->get("state"),
            );
            
            dd($books);
            return $this->render('search/book.html.twig', [
                'advanced_search_form' => $searchBookForm->createView(),
                'books' => $books
            ]);
        }
       
        return $this->render('search/book.html.twig', [
            'advanced_search_form' => $searchBookForm->createView(),
            'books' => $books
        ]);
    }
}
