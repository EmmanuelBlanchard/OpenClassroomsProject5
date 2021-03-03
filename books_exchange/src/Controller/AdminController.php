<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Publisher;
use App\Form\CategoryFormType;
use App\Form\LanguageFormType;
use App\Form\PublisherFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 * @package App\Controller
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/category/add", name="category_add")
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

            return $this->redirectToRoute('admin_home');
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
}
