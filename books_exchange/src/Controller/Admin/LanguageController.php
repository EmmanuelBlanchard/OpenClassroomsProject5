<?php

namespace App\Controller\Admin;

use App\Entity\Language;
use App\Form\LanguageFormType;
use App\Repository\LanguageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/language", name="admin_language_")
 * @package App\Controller\Admin
 */
class LanguageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(LanguageRepository $languageRepo): Response
    {
        return $this->render('admin/language/index.html.twig', [
            'language' => $languageRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
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

            return $this->redirectToRoute('admin_language_home');
        }

        return $this->render('admin/language/add.html.twig', [
            'addLanguageForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateLanguage(Language $language, Request $request): Response
    {
        $form = $this->createForm(LanguageFormType::class, $language);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($language);
            $entityManager->flush();

            return $this->redirectToRoute('admin_language_home');
        }

        return $this->render('admin/language/update.html.twig', [
            'updateLanguageForm' => $form->createView()
        ]);
    }

}
