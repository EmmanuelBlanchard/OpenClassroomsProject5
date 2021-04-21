<?php

namespace App\Controller\Admin;

use App\Entity\State;
use App\Form\StateFormType;
use App\Repository\StateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/state", name="admin_state_")
 * @package App\Controller\Admin
 */
class StateController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(StateRepository $stateRepo): Response
    {
        return $this->render('admin/state/index.html.twig', [
            'state' => $stateRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
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

            return $this->redirectToRoute('admin_state_home');
        }

        return $this->render('admin/state/add.html.twig', [
            'addStateForm' =>  $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateFormat(State $state, Request $request): Response
    {
        $form = $this->createForm(StateFormType::class, $state);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($state);
            $entityManager->flush();

            return $this->redirectToRoute('admin_state_home');
        }

        return $this->render('admin/state/update.html.twig', [
            'updateStateForm' => $form->createView()
        ]);
    }
    
}
