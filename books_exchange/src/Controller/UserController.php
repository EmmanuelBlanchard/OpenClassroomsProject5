<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/book/add", name="user_book_add")
     */
    public function addBook(): Response
    {
        $book = new Book;

        $form = $this->createForm(BookFormType::class, $book);

        return $this->render('user/book/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
