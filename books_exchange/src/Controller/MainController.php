<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {   $user = $this->getUser();
        //$books = $this->getDoctrine()->getRepository(Book::class)->findBy(['active' => true, 'exchangeRequest' => false]);
        // test does not work
        //$books = $this->getDoctrine()->getRepository(Book::class)->findBy(['active' => true, 'exchangeRequest' => false, 'user' => !$user]);
        //dd($books);
        // test does not work
        // Add a not equals parameter to your criteria
        $criteria = new Criteria();
        $criteria->where(Criteria::expr()->neq('user', $user));
        // Find all from the repository matching your criteria
        //$result = $entityRepository->matching($criteria);

        $books = $this->getDoctrine()->getRepository(Book::class);
        $result = $books->matching($criteria);
        
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
