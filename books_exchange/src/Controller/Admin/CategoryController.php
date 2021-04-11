<?php

namespace App\Controller\Admin;

use App\Entity\State;
use App\Entity\Author;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Publisher;
use App\Form\StateFormType;
use App\Form\AuthorFormType;
use App\Form\FormatFormType;
use App\Form\CategoryFormType;
use App\Form\LanguageFormType;
use App\Form\PublisherFormType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/category", name="admin_category_")
 * @package App\Controller\Admin
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepo): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'category' => $categoryRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addCategory(Request $request): Response
    {
        $category = new Category;

        $form = $this->createForm(CategoryFormType::class, $category);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_home');
        }

        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/publisher/add", name="publisher_add")
     */
    public function addPublisher(Request $request): Response
    {
        $publisher = new Publisher;

        $form = $this->createForm(PublisherFormType::class, $publisher);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publisher);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/publisher/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/language/add", name="language_add")
     */
    public function addLanguage(Request $request): Response
    {
        $language = new Language;

        $form = $this->createForm(LanguageFormType::class, $language);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($language);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/language/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/format/add", name="format_add")
     */
    public function addFormat(Request $request): Response
    {
        $format = new Format;

        $form = $this->createForm(FormatFormType::class, $format);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($format);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/format/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/state/add", name="state_add")
     */
    public function addState(Request $request): Response
    {
        $state = new State;

        $form = $this->createForm(StateFormType::class, $state);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($state);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/state/add.html.twig', [
            'form' =>  $form->createView()
        ]);
    }

    /**
     * @Route("/author/add", name="author_add")
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

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/author/add.html.twig', [
            'form' => $form->createview()
        ]);
    }
}
