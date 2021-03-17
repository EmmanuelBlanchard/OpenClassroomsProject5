<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        /*
        // display all books with true active status and no current exchange request and sort by date of availability in desc 
        $books = $this->getDoctrine()->getRepository(Book::class)->findBy(
            ['active' => true],
            ['exchangeRequest' => false],
            ['createdAt' => 'desc']
        );
        // Invalid order by orientation specified for App\Entity\Book#exchangeRequest
        */

        //$books = $this->getDoctrine()->getRepository(Book::class)->findBy(array('active' => true, 'exchangeRequest' => false, 'createdAt' => 'DESC'));
        // Could not convert PHP value 'DESC' of type 'string' to type 'datetime'. Expected one of the following types: null, DateTime
        
        $books = $this->getDoctrine()->getRepository(Book::class)->findBy(array('active' => true, 'exchangeRequest' => false));
        dd($books);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController', 'books' => $books
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
