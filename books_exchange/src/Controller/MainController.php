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
        $form = $this->createForm(SearchBookFormType::class);

        $search = $form->handleRequest($request);

        return $this->render('main/index.html.twig', [
            'books' => $bookRepo->findBy(['active' => true, 'exchangeRequest' => false],
            ['createdAt' => 'desc'], 10),
            'searchBookForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/howitworks", name="app_how_it_works")
     */
    public function howitworks(): Response
    {
        return $this->render('main/howitworks.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
