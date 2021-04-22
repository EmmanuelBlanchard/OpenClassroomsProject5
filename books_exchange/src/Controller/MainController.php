<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(BookRepository $bookRepo): Response
    {
        return $this->render('main/index.html.twig', [
            'books' => $bookRepo->findBy(['active' => true, 'exchangeRequest' => false], ['createdAt' => 'desc'], 10),
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
