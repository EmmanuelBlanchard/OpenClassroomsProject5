<?php

namespace App\Controller\Admin;

use App\Entity\Publisher;
use App\Form\PublisherFormType;
use App\Repository\PublisherRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/publisher", name="admin_publisher_")
 * @package App\Controller\Admin
 */
class PublisherController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PublisherRepository $publisherRepo): Response
    {
        return $this->render('admin/publisher/index.html.twig', [
            'publisher' => $publisherRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
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

            return $this->redirectToRoute('admin_publisher_home');
        }

        return $this->render('admin/publisher/add.html.twig', [
            'addPublisherForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updatePublisher(Publisher $publisher, Request $request): Response
    {
        $form = $this->createForm(PublisherFormType::class, $publisher);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publisher);
            $entityManager->flush();

            return $this->redirectToRoute('admin_publisher_home');
        }

        return $this->render('admin/publisher/update.html.twig', [
            'updatePublisherForm' => $form->createView()
        ]);
    }
}
