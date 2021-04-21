<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/author", name="admin_author_")
 * @package App\Controller\Admin
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AuthorRepository $authorRepo): Response
    {
        return $this->render('admin/author/index.html.twig', [
            'author' => $authorRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addAuthor(Request $request): Response
    {
        $author = new Author;

        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('admin_author_home');
        }

        return $this->render('admin/author/add.html.twig', [
            'addAuthorForm' => $form->createview()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateFormat(Author $author, Request $request): Response
    {
        $form = $this->createForm(AuthorFormType::class, $author);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('admin_author_home');
        }

        return $this->render('admin/author/update.html.twig', [
            'updateAuthorForm' => $form->createView()
        ]);
    }
}
