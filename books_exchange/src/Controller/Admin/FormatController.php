<?php

namespace App\Controller\Admin;

use App\Entity\Format;
use App\Form\FormatFormType;
use App\Repository\FormatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/format", name="admin_format_")
 * @package App\Controller\Admin
 */
class FormatController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FormatRepository $formatRepo): Response
    {
        return $this->render('admin/format/index.html.twig', [
            'format' => $formatRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
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

            return $this->redirectToRoute('admin_format_home');
        }

        return $this->render('admin/format/add.html.twig', [
            'addFormatForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateFormat(Format $format, Request $request): Response
    {
        $form = $this->createForm(FormatFormType::class, $format);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($format);
            $entityManager->flush();

            return $this->redirectToRoute('admin_format_home');
        }

        return $this->render('admin/format/update.html.twig', [
            'updateFormatForm' => $form->createView()
        ]);
    }

}
