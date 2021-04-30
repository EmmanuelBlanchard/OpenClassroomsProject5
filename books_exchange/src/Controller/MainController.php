<?php

namespace App\Controller;

use App\Form\SearchBookFormType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

        if($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/howitworks", name="app_how_it_works")
     */
    public function howitworks(): Response
    {
        return $this->render('main/howitworks.html.twig');
    }
}
