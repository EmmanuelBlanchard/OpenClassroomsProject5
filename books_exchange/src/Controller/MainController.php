<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Form\SearchBookFormType;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(BookRepository $bookRepo, Request $request): Response
    {
        $user = $this->getUser();
        $books = $bookRepo->findBooksActiveWithoutExchangeRequestNotOwnedByUser($user);

        $form = $this->createForm(SearchBookFormType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // we search for the books corresponding to the key words
            $books = $bookRepo->search(
                $search->get('words')->getData(),
                $search->get('category')->getData()
            );
        }

        return $this->render('main/index.html.twig', [
            'books' => $books,
            'searchBookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="book")
     */
    public function indexTest(BookRepository $bookRepo, PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();
        $books = $bookRepo->findBooksActiveWithoutExchangeRequestNotOwnedByUser($user);
        
        $form = $this->createForm(SearchFormType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // we search for the books corresponding to the key words
            $books = $bookRepo->findSearch(
                $search->get('words')->getData(),
                $search->get('categories')->getData()
            );
        }

        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );
    
        // parameters to template
        return $this->render('main/search.html.twig', [
            'books' => $pagination,
            'searchForm' => $form->createView()
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
