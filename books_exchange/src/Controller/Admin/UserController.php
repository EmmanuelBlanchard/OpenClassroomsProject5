<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/user", name="admin_user_")
 * @package App\Controller\Admin
 */
class UserController extends AbstractController
{
    /**
     * Lists the users of the site 
     * 
     * @Route("/", name="home")
     */
    public function index(UserRepository $userRepo): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'user' => $userRepo->findAll()
        ]);
    }

    /**
     * Update a user
     * 
     * @Route("/update/{id}", name="update")
     */
    public function updateUser(User $user, Request $request): Response
    {
        $form = $this->createForm(EditUserFormType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_user_home');
        }

        return $this->render('admin/user/update.html.twig', [
            'updateUserForm' => $form->createView()
        ]);
    }

    /**
     * Delete a user
     * 
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteUser(User $user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('message', 'Utilisateur supprimé avec succès');
        return $this->redirectToRoute('admin_user_home');
    }
}
